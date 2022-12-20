<?php

namespace App\Helpers;

use App\Exceptions\SystemConfigurationError;
use App\Http\Traits\ContractTrait;
use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\Contract;
use App\Models\Discount;
use App\Models\Level;
use App\Models\nationality;
use App\Models\Period;
use App\Models\Plan;
use App\Models\semester;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class FeesCalculatorClass
{
    private $plan;
    private $level;
    private $category;
    private $period;
    private $nationality;
    private $semesters;
    private $payments = [];
    private $year;
    private $firstInstallmentDate;
    private $last_Installment_date;
    private $installments_date_list = [];
    private $down_payment_amount = 0;
    private $down_payment = 0;
    private $vat_amount = 0;
    private $period_id = 0;
    private $period_discount_rate = 0;
    private $total_period_discount_amount = 0;
    private $tuition_fees = 0;
    private $tuition_fees_after_vat = 0;

    public function __construct($plan, $level, $period, $category, $nationality, $year)
    {
        $this->level = $level instanceof Level ? $level : Level::findOrFail($level);
        $this->category = $category instanceof Category ? $category : Category::findOrFail($category);
        $this->nationality = $nationality instanceof nationality ? $nationality : nationality::findOrFail($nationality);
        $this->year = $year instanceof AcademicYear ? $year : AcademicYear::findOrFail($year);
        $this->plan = $plan instanceof Plan ? $plan : Plan::findOrFail($plan);
        $this->period = $period instanceof Period ? $period : Period::find($period);
        $this->semesters = match_semesters($this->year, Carbon::now());

        $this->tuition_fees = semesters_tuition_fees($this->level, $this->semesters);

        if (is_null($this->level)) {
            throw new SystemConfigurationError("لم يتم العثور علي  الصف الدراسي التالي  .. تأكد من اعدادات الصف الدراسي بشكل ضحيح");
        }

        $this->period_id = $this->period->id ?? null;

        $discount = Discount::where('level_id', $this->level->id)->where('plan_id', $this->plan->id)->where('period_id', $this->period_id)->where('category_id', $this->category->id)->first();

        $this->period_discount_rate = $discount ? $discount->rate : 0;
    }

    /**
     * @param \App\Models\Plan $plan
     * @param \App\Models\semester $semesters
     * @return App\Helpers\FeesCalculatorClass;
     */

    public function getContractPayments()
    {
        $this->vat_amount = $this->nationality->vat_rate ? ($this->tuition_fees / 100) * $this->nationality->vat_rate : 0;

        $this->tuition_fees_after_vat = $this->tuition_fees + $this->vat_amount;

        switch ($this->plan->plan_based_on) {
            case 'total':
                return $this->applyCashPaymentPlan();
                break;

            case 'semester':
                return $this->applySemesterPlan();
                break;

            default:
                return  $this->setInstallmentDueDate()
                    ->setLastInstallmentDate()
                    ->getInstallmentsCount()
                    ->applyInstallmentPlan();
                break;
        }
    }


    /**
     * @param \App\Models\Plan $plan
     * @param \App\Models\semester $semesters
     * @return double|int;
     */
    public function getDiscountType()
    {
        return $this->plan->fixed_discount;
    }

    public function getPayments(): array
    {
        return $this->payments;
    }

    public function getPrtiodDiscount()
    {
        return $this->total_period_discount_amount;
    }

    public function getVatAmount()
    {
        return $this->vat_amount;
    }

    public function getVatRate()
    {
        return $this->nationality->vat_rate;
    }

    public function getTuitionFeess(bool $withVat = false)
    {
        return $withVat ?  $this->tuition_fees_after_vat :  $this->tuition_fees;
    }

    public function getDownPaymentAmount(): int|float
    {
        return $this->down_payment_amount;
    }

    public function getDownPaymentPecent(): int|float
    {
        return $this->down_payment;
    }

    public function getRegisteredSemester()
    {
        return $this->semesters;
    }

    private function applyCashPaymentPlan()
    {
        $this->newPayment('الرسوم الدراسية', $this->tuition_fees, Carbon::today(), 1);
        $this->down_payment_amount = $this->tuition_fees;
        return $this;
    }

    private function applySemesterPlan()
    {
        $is_contract_payment = true;
        foreach ($this->semesters as $semester) {
            $semester_fees = $this->level->tuition_fees / 100 * $semester->semester_in_fees;
            $payment_due = Carbon::parse($semester->semester_start)->subDays($this->plan->payment_due_determination);

            $this->newPayment('رسوم ' . $semester->semester_name, $semester_fees, $payment_due, $is_contract_payment);
            if ($is_contract_payment) {
                $this->down_payment_amount = $semester_fees;
            }
            $is_contract_payment = false;
        }
        return $this;
    }

    private function applyInstallmentPlan()
    {
        $remain_fees =  $this->tuition_fees;
        if ($this->plan->down_payment) {
            # calculate down payment
            $this->down_payment = $this->plan->down_payment;

            $this->down_payment_amount = $this->tuition_fees / 100 *  $this->down_payment;
            $remain_fees -= $this->down_payment_amount;

            $this->newPayment('دفعة التعاقد', $this->down_payment_amount, Carbon::now(), 1);
        }

        $installment_count = count($this->installments_date_list);
        $installment_value = $remain_fees / $installment_count;

        foreach ($this->installments_date_list as $k => $due_date) {
            $this->newPayment($this->installment_name($k), $installment_value, $due_date, !$this->payments);
        }
        return $this;
    }

    private function setInstallmentDueDate()
    {
        $date = Carbon::now();
        if ($this->plan->beginning_installment_calculation < Carbon::now()->day) {
            $date = $date->addMonth();
        }
        $this->firstInstallmentDate = Carbon::createFromFormat('Y-m-d', sprintf('%s-%s-%s', $date->year, $date->month, $this->plan->payment_due_determination));

        return $this;
    }

    private function setLastInstallmentDate()
    {
        if (!$this->year->last_installment_date || !$this->plan->payment_due_determination) {
            throw new SystemConfigurationError(sprintf('خطأ في اعدادات العام الدراسي %s', $this->year->year_name));
        }
        $this->last_Installment_date = Carbon::createFromFormat('Y-m-d', sprintf('%s-%s-%s', $this->year->last_installment_date->format('Y'), $this->year->last_installment_date->format('m'), $this->plan->payment_due_determination));
        return $this;
    }

    private function getInstallmentsCount()
    {
        $next_date = $this->firstInstallmentDate;

        do {
            array_push($this->installments_date_list, $next_date->format('Y-m-d'));
            $next_date = $next_date->addmonth();
            if ($next_date > $this->last_Installment_date) {
                break;
            }
        } while (true);

        return $this;
    }

    public function calculatePeriodDiscount(array $transaction)
    {
        $period_discount = round($transaction['residual_amount'] / 100 * $this->period_discount_rate, 2);

        $transaction['period_id'] = $this->period->id ?? null;
        $transaction['category_id'] = $this->category->id;
        $transaction['discount_rate'] = $this->period_discount_rate;
        $transaction['period_discount'] = $period_discount;
        $transaction['amount_after_discount'] = round($transaction['amount_before_discount'] - $period_discount, 2);
        $transaction['residual_amount'] =  round($transaction['residual_amount'] - $period_discount, 2);

        $this->total_period_discount_amount += $period_discount;
        $this->period_id = $this->period->id ?? null;

        return $transaction;
    }

    private function newPayment(string $name, int $amount, $due_date, bool $is_contract_payment = false)
    {
        $vat = $this->CalculateVats($amount);

        $transaction = $this->calculatePeriodDiscount(
            [
                'installment_name' =>  $name,
                'amount_before_discount' => $amount,
                'vat_amount' => $vat,
                'residual_amount' => round($amount + $vat, 2),
                'amount_after_discount' => $amount,
                'payment_due' => $due_date,
                'transaction_type' => 'tuition',
                'is_contract_payment' => $is_contract_payment
            ]
        );
        array_push($this->payments, $transaction);
    }

    /**
     * Execute the console command.
     * @param int $num_of_installments
     * @param int $i installment index
     * @return string
     */
    private function installment_name($i)
    {
        $names = [
            'الأول',
            'الثاني',
            'الثالث',
            'الرابع',
            'الخامس',
            'السادس',
            'السابع',
            'الثامن',
            'التاسع',
            'العاشر',
        ];

        return isset($names[$i]) ? 'القسط ' . $names[$i] : 'القسط رقم ' . $i;
    }

    private function CalculateVats($value)
    {
        return  $this->nationality->vat_rate ? $value / 100 * $this->nationality->vat_rate : 0;
    }
}
