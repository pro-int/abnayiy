<?php

namespace App\Services;

use App\Http\Traits\ContractTrait;
use App\Models\Contract;
use App\Models\guardian;
use App\Models\PaymentAttempt;
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
                'payment_status' => 0,
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
                $contract->transactions()->delete();
                $this->StoreNewTransaction($newTransaction);
                $contract->update_total_payments();
            }else{
                $refundResidual = 0;
                if($contract->total_fees != $contract->total_paid){
                    foreach ($contract->transactions as $transaction){
                        if($transaction->residual_amount != 0 && $transaction->paid_amount != 0){
                            $transaction->residual_amount = 0;
                            $transaction->amount_before_discount = $transaction->paid_amount;
                            $transaction->amount_after_discount = $transaction->paid_amount;
                            $transaction->vat_amount = 0;
                            $transaction->period_discount=0;
                            $transaction->coupon_discount=0;
                            $transaction->payment_status =1;
                            $transaction->save();
                            $refundResidual += $transaction->residual_amount;
                        }else if($transaction->residual_amount != 0){
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
                    $refundResidualFees = 0-($refund);

                    $residualTransaction = [
                        'contract_id' => $contract->id,
                        'installment_name' => 'رسوم مسترجعه من طلب الانسحاب',
                        'amount_before_discount' => $refundResidualFees,
                        'discount_rate'  => 0,
                        'period_discount' => 0,
                        'coupon_discount' => 0,
                        'amount_after_discount' => $refundResidualFees,
                        'vat_amount' => 0,
                        'residual_amount' => 0,
                        'paid_amount' => $refundResidualFees,
                        'payment_status' => 1,
                        'transaction_type' => 'withdrawal',
                        'debt_year_id' => $contract->academic_year_id,
                        'payment_due' => Carbon::now()
                    ];
                    $result = $this->StoreNewTransaction($residualTransaction);
                    $contract->update_total_payments();

                    return PaymentAttempt::create([
                            'transaction_id' => $result->id,
                            'payment_method_id' => 1,
                            'requested_ammount' => $refundResidualFees,
                            'received_ammount' => $refundResidualFees,
                            'coupon' => null,
                            'coupon_discount' => 0,
                            'period_id' => null,
                            'period_discount' => 0,
                            'bank_id' => null,
                            'payment_network_id' => null,
                            'approved' => 1
                        ]);
                }else{
                    $positiveRefund = abs($refund);
                }

                $newTransaction["paid_amount"] = $amount_fees - $positiveRefund;
                $newTransaction["residual_amount"] = $newTransaction["amount_after_discount"] - $newTransaction["paid_amount"];


                if($amount_fees > $contract->total_paid){
                    $newTransaction["amount_after_discount"] = $newTransaction["residual_amount"] - $refundResidual;
                    $newTransaction["amount_before_discount"] = $newTransaction["residual_amount"] - $refundResidual;
                    $newTransaction["residual_amount"] = $newTransaction["amount_after_discount"];
                    $newTransaction["paid_amount"] = 0;
                }

                if($newTransaction["residual_amount"] == 0){
                    $newTransaction["payment_status"] = 1;
                }

                $this->StoreNewTransaction($newTransaction);
                $contract->update_total_payments();
            }

        }

    }

}
