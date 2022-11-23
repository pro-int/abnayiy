<?php

namespace App\Http\Traits;

use App\Models\Transaction;
use App\Http\Traits\CouponeTrait;
use App\Models\AcademicYear;
use App\Models\Discount;
use App\Models\guardian;
use App\Models\PaymentAttempt;
use App\Models\Period;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

trait TransactionTrait
{
    use CouponeTrait;

    public $transaction_data = [];
    public $coupon_code;
    public $transaction;
    public $check_coupon;
    public $fireByAdmin;
    public $requested_ammount;
    public $baseAmount;
    public $paid_vat;
    public $unPaid_vat;
    /**
     * @param String $coupon_code
     * @param \App\Models\Transaction $transaction
     * @return
     */

    public function getTransactionAmounts(transaction $transaction, $coupon_code = null, $requested_ammount = null, $check_coupon = true)
    {
        $this->coupon_code = $coupon_code;
        $this->transaction = $transaction;
        $this->check_coupon = $check_coupon;

        // $vat_base = $transaction->vat_amount > 0 ? $transaction->vat_amount / $transaction->amount_after_discount : 0;

        // $this->unPaid_vat =  $vat_base > 0 ? $vat_base * ($transaction->residual_amount -  $transaction->vat_amount) : 0;

        // $this->paid_vat = $vat_base > 0 ? $vat_base * ($transaction->paid_amount) : 0;

        // $this->baseAmount = $transaction->residual_amount- $this->unPaid_vat;

        $this->requested_ammount = $requested_ammount;

        $this->ChecktransactionStatus();

        return $this->transaction_data;
    }


    /**
     * @param \App\Models\Transaction $transaction
     * @param array $discount_data
     * @return array $data
     */
    protected function ChecktransactionStatus()
    {

        if ($this->transaction->residual_amount <= 0) {
            return  $this->transaction_data += [
                'amount_before_discount' => $this->transaction->amount_before_discount,
                'amount_after_discount' => $this->transaction->amount_after_discount,
                'vat_amount' =>  $this->transaction->vat_amount,
                'old_discount' => $this->transaction->period_discount + $this->transaction->coupon_discount,
                'paid_amount' =>  $this->transaction->paid_amount,
                'old_residual_amount' =>  $this->transaction->residual_amount,
                'period_discount' => $this->transaction->period_discount,
                'is_fixed_discount' => $this->transaction->fixed_discount,
                'new_period_discount' => 0,
                'coupon_discount' => $this->transaction->coupon_discount,
                'coupon_code' => null,
            ];
        }

        return $this->period_discount();
    }
    /**
     * @param \App\Models\Transaction $transaction
     * @param array $discount_data
     * @return array $data
     */
    protected function calculate_amount()
    {

        if ($this->transaction->is_old_transaction == 1 || $this->transaction->transaction_type == 'bus' || $this->transaction->fixed_discount == 1) {
            $amount_before_discount = $this->transaction->amount_before_discount;
            $amount_after_discount = $this->transaction->amount_after_discount - $this->transaction_data['coupon_discount'];
            $old_discount = $this->transaction->coupon_discount;
        } else {

            $amount_before_discount = $this->transaction->amount_before_discount;
            $amount_after_discount = $this->transaction->amount_after_discount - $this->transaction_data['new_period_discount'] - $this->transaction_data['coupon_discount'];

            $old_discount = $this->transaction->period_discount + $this->transaction->coupon_discount;
        }


        $residual_amount = $this->transaction->residual_amount - $this->transaction_data['new_period_discount'] -  $this->transaction_data['coupon_discount'];



        $this->transaction_data += [
            'amount_before_discount' => round($amount_before_discount, 2) ?? 0,
            'amount_after_discount' => round($amount_after_discount + $this->transaction->vat_amount, 2) ?? 0,
            'vat_amount' => round($this->transaction->vat_amount, 2),
            'paid_amount' => round($this->transaction->paid_amount, 2) ?? 0,
            'old_discount' => round($old_discount, 2) ?? 0,
            'residual_amount' => round($residual_amount, 2) ?? 0,
            'old_residual_amount' => $this->transaction->residual_amount,
        ];

        return  $this->transaction_data;
    }

    /**
     * @return function $this->has_Coupone()
     */
    protected function period_discount()
    {
        if ($this->transaction->is_old_transaction == 1 || $this->transaction->transaction_type == 'bus' || $this->transaction->fixed_discount == 1) {
            $this->transaction_data += [
                'discount_rate' => $this->transaction->discount_rate,
                'period_discount' => round($this->transaction->period_discount, 2) ?? 0,
                'new_period_discount' => 0,
                'period_id' => $this->transaction->period_id,
                'is_fixed_discount' => $this->transaction->fixed_discount
            ];
        } else {

            $year = AcademicYear::findOrFail($this->transaction->academic_year_id);
            $period = currentPeriod($year);
            $category = guardian::getCategory($this->transaction->guardian_id);

            if ($period) {
                $discount = Discount::where('level_id', $this->transaction->level_id)->where('plan_id', $this->transaction->plan_id)->where('period_id', $period->id)->where('category_id', $category->id)->first();
                $discount_rate = $discount ? $discount->rate : 0;
            } else {
                $discount_rate = 0;
            }


            $new_period_discount =  $discount_rate > 0 ? (($this->transaction->residual_amount) / 100) * $discount_rate : $discount_rate;

            $period_discount = $this->transaction->period_discount;

            if ($new_period_discount && !empty($this->requested_ammount)) {
                $new_period_discount = $new_period_discount * ($this->requested_ammount / $this->transaction->residual_amount);
            }

            $this->transaction_data += [
                'discount_rate' => $discount_rate,
                'period_discount' => round($period_discount, 2) ?? 0,
                'new_period_discount' => round($new_period_discount, 2) ?? 0,
                'period_id' => $period->id ?? null,
                'is_fixed_discount' => $this->transaction->fixed_discount

            ];
        }
        return $this->has_Coupone();
    }

    protected function CreatePaymentAttempt($transaction, $request, $data = [], $guardian_id = null, $reqFromParent = null) : PaymentAttempt
    {
        if($reqFromParent){
            $requested_ammount =  $reqFromParent->requested_ammount ?? null;

            $transaction_data =  $this->getTransactionAmounts($transaction, $reqFromParent->coupon??null, $requested_ammount);

        }else{
            $requested_ammount = $request->filled('requested_ammount') && $request->requested_ammount < $request->max_amount ? $request->requested_ammount : null;
            $transaction_data =  $this->getTransactionAmounts($transaction, $request->coupon, $requested_ammount);

        }


        if (!$requested_ammount) {
            $requested_ammount = $transaction_data['residual_amount'];
        }

        $user_id = null == $guardian_id ? Auth::id() : $guardian_id;
        $location = null == $guardian_id ? 'byUser-U' : 'byAdmin-U';
        $file_path = [];


        if ($request->has('receipt') && $request->file('receipt') ) {

            $file = $request->file('receipt');

            // generate a new filename. getClientOriginalExtension() for the file extension
            $filename = $guardian_id . '/receipt-' . $location . $user_id . '-T' . $transaction->id . '-' . time() . '.' . $file->getClientOriginalExtension();

            $path = Storage::disk('public')->putFileAs(
                'receipts',
                $file,
                $filename
            );
            $file_path = ['attach_pathh' => $path];
        }

        return PaymentAttempt::create($file_path + [
            'transaction_id' => $transaction->id,
            'payment_method_id' => $reqFromParent ? $reqFromParent->method_id : $request->method_id,
            'requested_ammount' => $requested_ammount,
            'coupon' => $transaction_data['coupon_code'],
            'coupon_discount' => $transaction_data['coupon_discount'],
            'period_id' => $transaction_data['period_id']?? 0,
            'period_discount' => $transaction_data['new_period_discount'],
            'bank_id' => $reqFromParent ? $reqFromParent->bank_id : $request->bank_id,
            'payment_network_id' => $request->payment_network_id
        ] + $data);

    }

    protected function Get_transactions($id)
    {
        return transaction::select('transactions.*', 'contracts.student_id', 'contracts.academic_year_id', 'contracts.level_id', 'contracts.plan_id', 'contracts.vat_rate', 'plans.fixed_discount', 'students.guardian_id','contracts.status')
            ->leftjoin('contracts', 'contracts.id', 'transactions.contract_id')
            ->leftjoin('plans', 'plans.id', 'contracts.plan_id')
            ->leftjoin('students', 'students.id', 'contracts.student_id')
            ->find($id);
    }
}
