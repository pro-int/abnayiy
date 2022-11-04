<?php

namespace App\Helpers;

use App\Exceptions\SystemConfigurationError;
use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Level;
use App\Models\nationality;
use App\Models\Period;
use App\Models\Plan;
use App\Models\semester;
use App\Models\User;
use Carbon\Carbon;

class TuitionFeesClass
{
    public $plan;
    public $level;
    public $category;
    public $period;
    public $nationality;
    public $year;
    public $user;
    public $semesters;
    public $data = [];
    /**
     * calculate Tuition Fees
     * @return array $data
     */
    function __construct($plan, $level, $period, $category, $nationality, $year, $user = null)
    {

        $this->level = $level instanceof Level ? $level : Level::findOrFail($level);
        $this->category = $category instanceof Category ? $category : Category::findOrFail($category);
        $this->nationality = $nationality instanceof nationality ? $nationality : nationality::findOrFail($nationality);
        $this->year = $year instanceof AcademicYear ? $year : AcademicYear::findOrFail($year);
        $this->plan = $plan instanceof Plan ? $plan : Plan::findOrFail($plan);
        $this->period = $period instanceof Period ? $period : Period::find($period);
        $this->semesters = match_semesters($this->year, Carbon::now());

        if (is_null($this->level)) {
            throw new SystemConfigurationError("لم يتم العثور علي  الصف الدراسي التالي  .. تأكد من اعدادات الصف الدراسي بشكل ضحيح");
        }

        if (is_null($user)) {
            $this->user = auth()->user();
        } else {
            $this->user = $user instanceof User ? $user : User::findOrFail($user);
        }
    }

    public function calculateTuitionFees()
    {
        $tuition_fees = semesters_tuition_fees($this->level, $this->semesters);

        $vat_amount = $this->nationality->vat_rate ? ($tuition_fees / 100) * $this->nationality->vat_rate : 0;

        $tuition_fees_after_vat = $tuition_fees + $vat_amount;

        $minimum_down_payment = 0;
        if ($this->year->min_tuition_percent) {
            # min_tuition_percent applied
            if ($this->plan->installments > 1) {
                # installments applied
                $minimum_down_payment = $tuition_fees / 100 * $this->year->min_tuition_percent;
            } else {
                $minimum_down_payment = $tuition_fees;
            }
        }

        $this->data['tuition_fees'] = $tuition_fees;
        $this->data['vat_amount'] = $vat_amount;
        $this->data['tuition_fees_after_vat'] = $tuition_fees_after_vat;
        $this->data['minimum_down_payment'] = $minimum_down_payment;
        $this->data['category_name'] = $this->category->category_name;
        $this->data['category_color'] = $this->category->color;
        $this->data['semesters'] = $this->semesters->pluck('id');

        $this->data['installments'] = $this->InstallmentCalculation();

        return $this->calculatePeriodDiscount();
    }

    protected function InstallmentCalculation()
    {
        $installments = [];

        $remain_fees =  $this->data['tuition_fees'];

        if ($this->data['minimum_down_payment'] > 0) {
            $vat = $this->CalculateVats($this->data['minimum_down_payment']);

            array_push($installments, [
                'order' => 0,
                'installment_name' =>  $this->plan->installments == 1 ? 'الرسوم الدراسية' : 'دفعة التعاقد',
                'amount_before_discount' => $this->data['minimum_down_payment'],
                'vat_amount' => $vat,
                'residual_amount' => round($this->data['minimum_down_payment'] + $vat,2),
                'payment_due' => Carbon::now(),
                'transaction_type' => 'tuition',
                'is_contract_payment' => 1
            ]);
            $remain_fees -= $this->data['minimum_down_payment'];
        }

        if ($remain_fees) {
            # if theres remain school fees
            $installment_value = $this->plan->installments > 1 ? $remain_fees / $this->plan->installments : $remain_fees;
            $vat = $this->CalculateVats($installment_value);

            for ($i = 0; $i < $this->plan->installments; $i++) {

                array_push($installments, [
                    'order' => $i + 1,
                    'installment_name' =>  $this->installment_name($this->plan->installments, $i),
                    'amount_before_discount' => $installment_value,
                    'vat_amount' => $vat,
                    'residual_amount' => round($installment_value + $vat,2),
                    'payment_due' => $this->period->apply_end ?? null,
                    'transaction_type' => 'tuition',
                    'is_contract_payment' => $this->plan->installments == 1 ? 1 : 0,
                ]);
            }
        }

        return $installments;
    }

    public function calculatePeriodDiscount()
    {
        $period_id = $this->period->id ?? null;

        $discount = Discount::where('level_id', $this->level->id)->where('plan_id', $this->plan->id)->where('period_id', $period_id)->where('category_id', $this->category->id)->first();

        $this->data['discount_rate'] = $discount ? $discount->rate : 0;


        $this->data['due_date']  = $this->data['discount_rate'] &&  $this->period ? $this->period->apply_end : null;

        $total_residual_amount = 0;
        $total_period_discount = 0;

        foreach ($this->data['installments'] as $key => $installment) {
            $period_discount = round($installment['residual_amount'] / 100 * $this->data['discount_rate'], 2);

            $this->data['installments'][$key]['period_id'] = $this->period->id ?? null;
            $this->data['installments'][$key]['category_id'] = $this->category->id;
            $this->data['installments'][$key]['discount_rate'] = $this->data['discount_rate'];
            $this->data['installments'][$key]['period_discount'] = $period_discount;
            $this->data['installments'][$key]['amount_after_discount'] = round($installment['amount_before_discount'] - $period_discount, 2);
            $this->data['installments'][$key]['residual_amount'] =  round($installment['residual_amount'] - $period_discount, 2);

            $total_residual_amount += $installment['residual_amount'] - $period_discount;
            $total_period_discount += $period_discount;

            if ($installment['is_contract_payment'] == 1) {
                $this->data['minimum_down_payment'] = $installment['residual_amount'] - $period_discount;
            }
        }

        $this->data['period_discount'] = $total_period_discount;
        $this->data['period_id'] = $this->period->id ?? null;

        $this->data['tuition_fees_after_discount'] = $total_residual_amount;


        $this->data['tuition_fees_after_down_payment'] = $this->data['tuition_fees_after_discount'] - $this->data['minimum_down_payment'];

        return $this->data;
    }

    /**
     * Execute the console command.
     * @param int $num_of_installments 
     * @param int $i installment index
     * @return string
     */
    public function installment_name($num_of_installments, $i)
    {
        $names = [
            'الأولي',
            'الثانيه',
            'الثالثه',
            'الرابعه',
            'الخامسه',
            'السادسه',
            'السابعه',
            'الثامنه',
        ];

        return $num_of_installments > 1 ? (isset($names[$i]) ? 'الدفعة ' . $names[$i] : 'الدفعة رقم ' . $i) :  'المصروفات الدراسية';
    }

    protected function CalculateVats($value)
    {
        return  $this->nationality->vat_rate ? $value / 100 * $this->nationality->vat_rate : 0;
    }
}
