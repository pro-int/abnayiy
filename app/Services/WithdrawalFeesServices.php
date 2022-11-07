<?php

namespace App\Services;

use App\Http\Traits\ContractTrait;
use App\Models\Contract;
use App\Models\guardian;
use App\Models\Student;
use Carbon\Carbon;

class WithdrawalFeesServices
{
    use ContractTrait;

    public function __construct()
    {
    }

    public function saveWithdrawalFees($withdrawalApplication){

        $contract = Contract::select("contracts.*")
            ->where("contracts.academic_year_id", $withdrawalApplication->academic_year_id)
            ->where("contracts.student_id", $withdrawalApplication->student_id)
            ->with('transactions')
            ->first();

        $amount_fees = $withdrawalApplication->amount_fees;

        if($contract){

            $newTransaction = [
                'contract_id' => $contract->id,
                'installment_name' => 'رسوم انسحاب',
                'amount_before_discount' => $amount_fees,
                'discount_rate'  => 0,
                'period_discount' => 0,
                'coupon_discount' => 0,
                'amount_after_discount' => $amount_fees,
                'vat_amount' => 0,
                'residual_amount' => $amount_fees,
                'paid_amount' => 0,
                'transaction_type' => 'withdrawal',
                'debt_year_id' => $contract->academic_year_id,
                'payment_due' => Carbon::now()
            ];

            $studentObject = Student::find($withdrawalApplication->student_id);
            $guardian = guardian::find($studentObject->guardian_id);
            $meta['student_name'] = $studentObject->student_name;
            $meta['student_id'] =$studentObject->id;
            $meta['description'] = "اصل المبلغ المدفوع " . $contract->total_paid . " والمبلغ المتبقي بعد خصم رسوم الانسحاب وهي " . $amount_fees;

            if($contract->total_paid == 0){
                $this->addNewWithdrawalTransaction($contract, $newTransaction, $amount_fees);
            }else{

                if($contract->total_fees != $contract->total_paid){
                    foreach ($contract->transactions as $transaction){
                        if($transaction->residual_amount != 0){
                            $transaction->delete();
                        }
                    }
                }

                $refund = $contract->total_paid - $amount_fees;
                $positiveRefund = 0;

                if($refund >= 0){
                    $wallet = $guardian->getWallet("balance");
                    if($wallet){
                        $wallet->depositFloat($refund, $meta);
                    }
                }else{
                    $positiveRefund = abs($refund);
                }

                $newTransaction["paid_amount"] = $amount_fees - $positiveRefund;
                $newTransaction["residual_amount"] = $newTransaction["amount_after_discount"] - $newTransaction["paid_amount"];

                $this->addNewWithdrawalTransaction($contract, $newTransaction, $amount_fees);

            }

        }

    }

    private function addNewWithdrawalTransaction($contract, $transaction, $withdrawal_fees): void
    {
        $contract->transactions()->delete();
        $this->StoreNewTransaction($transaction);
        $contract->update_total_payments($withdrawal_fees);
    }
}
