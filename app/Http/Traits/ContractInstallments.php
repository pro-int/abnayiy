<?php

namespace App\Http\Traits;

use App\Helpers\FeesCalculatorClass;
use App\Helpers\TuitionFeesClass;
use App\Models\Discount;
use App\Models\guardian;
use App\Models\Plan;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait ContractInstallments
{
    private $plan;
    private $category;
    private $contract;
    private $guardian;
    private $period;
    private $ammount = [];
    private $transportation = [];


    /**
     * calculate transaction ammounts.
     * @param \App\Models\Contract $contract 
     * @param int $guardian_id  
     * @return boolean
     */

    public function CreateInstallments($contract, $student)
    {
        $this->contract = $contract;
        $this->period  = currentPeriod($this->year);
    
        $this->plan = Plan::findOrFail($contract->plan_id);

        // $this->guardian = guardian::firstOrFail($student->guardian_id)->category;
        $this->category = guardian::findorFail($student->guardian_id)->category;

        // $tuition_fees = new TuitionFeesClass($this->plan, $contract->level_id, $period, $this->category, $student->nationality_id, $contract->academic_year_id, $student->guardian_id);
        // $tuition_fees = $tuition_fees->calculateTuitionFees();

        $fees = new FeesCalculatorClass($this->plan, $contract->level_id, $this->period, $this->category, $student->nationality_id, $contract->academic_year_id);

        $installments =  $fees->getContractPayments()->getPayments();

        if ($this->plan && $this->category) {
            
            foreach ($installments as $installment) {
                if (! $this->plan->fixed_discount) {
                    $installment['period_discount'] = 0;
                    $installment['amount_after_discount'] = $installment['amount_before_discount'];
                    $installment['residual_amount'] = $installment['amount_before_discount'] + $installment['vat_amount'];
                }
                $this->StoreNewTransaction($installment + ['contract_id' => $this->contract->id]);
            }

            $contract->update_total_payments();

            return true;
        } else {
            return false;
        }
    }

    /**
     * calculate transaction ammounts.
     * @return array
     */
    public function CalculateTransactionAmounts()
    {
        $discount_rate = 0;
        if ($this->plan->fixed_discount) {
            $period_id = $this->period->id ?? null;

            $discount = Discount::where('level_id', $this->contract->level_id)->where('plan_id', $this->plan->id)->where('period_id', $period_id)->where('category_id', $this->category->id)->first();

            $discount_rate = $discount ? $discount->rate : 0;
        }

        $amount_before_discount = $this->plan->installments > 0 ?  $this->contract->tuition_fees / $this->plan->installments : $this->contract->tuition_fees;

        $vat_amount = $this->contract->vat_rate ? ($amount_before_discount / 100) * $this->contract->vat_rate : 0;

        $amount_after_vat = $amount_before_discount + $vat_amount;

        $period_discount = $discount_rate ? ($amount_after_vat  / 100) * $discount_rate : 0;

        $amount_after_discount = $amount_before_discount - $period_discount;


        return [
            'amount_before_discount' => $amount_before_discount,
            'vat_amount' => $vat_amount,
            'discount_rate' => $discount_rate,
            'period_discount' => $period_discount,
            'amount_after_discount' => $amount_after_discount,
            'residual_amount' => $amount_after_discount + $vat_amount,
        ];
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

        /**
     * @param array $transactionArray --transaction data to store
     * @return \App\Models\Transaction $transaction -- created transaction 
     */
    protected function StoreNewTransaction(array $transactionArray)
    {
        $transaction = Transaction::create($transactionArray + ['admin_id' => Auth::id()]);

        if (!$transaction) {
            throw new \Exception("خطأ اثناء تسجيل الدفعة  : " . $transactionArray['installment_name'], 1);
        }
        return $transaction;
    }
}
