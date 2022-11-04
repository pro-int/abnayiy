<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'installment_name',
        'period_id',
        'category_id',
        'amount_before_discount',
        'discount_rate',
        'period_discount',
        'coupon_discount',
        'amount_after_discount',
        'vat_amount',
        'residual_amount',
        'paid_amount',
        'transaction_type',
        'payment_due',
        'debt_year_id',
        'is_contract_payment',
        'admin_id'
    ];

    public static function boot()
    {
        parent::boot();
      
        static::deleting(function ($item) {
            $item->PaymentAttempt()->delete();
        });
    }


    public function PaymentAttempt()
    {
        return $this->hasMany(PaymentAttempt::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class, 'id', 'contract_id');
    }


    // public static function update_installments(Carbon $date)
    // {
    //     # find contracts that have transactions due today
    //     $contracts = Contract::select('contracts.id', 'contracts.student_id', 'contracts.academic_year_id', 'contracts.plan_id', 'contracts.total_fees', 'students.guardian_id')->whereHas('transactions', function (Builder $query) use ($date) {
    //         $query->whereDate('transactions.payment_due', $date)->where('transactions.payment_status', 0);
    //     })->with('transactions')
    //         ->leftjoin('students', 'students.id', 'contracts.student_id')
    //         ->get();

    //     // get currant period
    //     $currnat_period = currentPeriod($this->GetAcademicYear());
    //     if ($contracts && $currnat_period) {
    //         // loop on contracts
    //         foreach ($contracts as $contract) {
    //             $plan = Plan::find($contract->plan_id);
    //             $category = guardian::getCategory($contract->guardian_id);
    //             if ($plan && $category) {
    //                 $ammount = Discount::calculate_discount($contract, $currnat_period, $plan, $category);
    //                 // loop on contract transactions
    //                 foreach ($contract->transactions as $transaction) {
    //                     $transaction->period_id =  $currnat_period->id;
    //                     $transaction->amount_before_discount =  $ammount['amount_before_discount'];
    //                     $transaction->discount_rate =  $ammount['discount_rate'];
    //                     $transaction->period_discount =  $ammount['period_discount'];
    //                     $transaction->amount_after_discount =  $ammount['amount_after_discount'];
    //                     $transaction->vat_amount =  $ammount['vat_amount'];
    //                     $transaction->payment_due =  $currnat_period->apply_end;
    //                     $transaction->save();
    //                 }
    //             }
    //         }
    //         return $contracts;
    //     } else {
    //         return [];
    //     }
    // }

    /**
     * @param App\Modeals\Transaction $transaction
     * @param array $discount_data
     * @return array $data
     */
    public function calculate_amount($discount_data)
    {

        $discount_value = $discount_data['coupon_discount'];

        $period_discount =  ($this->amount_before_discount / 100) * $this->discount_rate;

        $amount_after_coupon  = $this->amount_after_discount - $this->paid_amount - $discount_value - $period_discount;

        $new_total = $this->amount_before_discount - $discount_value - $this->coupon_discount - $period_discount;

        $vat_amount = $discount_value > 0 ? ($new_total / 100) * $this->contract->vat_rate : $this->vat_amount;

        $new_residual_amount = $discount_value  + $period_discount > 0 ? $amount_after_coupon + $vat_amount : $this->residual_amount;

        return [
            'amount_before_discount' => round($this->amount_before_discount, 2) ?? 0,
            'period_discount' => round($period_discount, 2) ?? 0,
            'vat_amount' => round($vat_amount, 2) ?? 0,
            'amount_after_discount' => round($amount_after_coupon, 2) ?? 0,
            'paid_amount' => round($this->paid_amount, 2) ?? 0,
            'old_discount' => round($this->coupon_discount, 2) ?? 0,
            'residual_amount' => round($new_residual_amount, 2) ?? 0,
        ];
    }

    public static function get_transaction_span(Contract $contract, $paid)
    {
        # calculate payment persent
        $persent = $paid / ($contract->total_fees) * 100;
        if ($persent < 100) {
            $spna = '<abbr title="مدفوع ' . $paid . ' من اصل ' . $contract->total_fees . '"><span class="badge badge-warning">تم سداد ' . round($persent,2) . ' %</span></abbr>';
        } else {
            $spna = '<span class="badge badge-success">تم السداد</span>';
        }
        return $spna;
    }

    /**
     * @param App\Model\PaymentAttempt $PaymentAttempt
     */
    public function update_transaction()
    {
        $PaymentAttempts = $this->PaymentAttempt();
        $contract = $this->contract;

        $plan = Plan::findOrFail($contract->plan_id);

        $total_coupon_discount = $PaymentAttempts->where('approved', 1)->sum('coupon_discount');

        $total_period_discount = $plan->fixed_discount || $this->is_old_transaction == 1 || in_array($this->transaction_type, ['bus', 'debt']) ? $this->period_discount : $PaymentAttempts->where('approved', 1)->sum('period_discount');
        $total_paid = $PaymentAttempts->where('approved', 1)->sum('received_ammount');

        $this->paid_amount = round($total_paid, 2);
        $this->period_discount = round($total_period_discount, 2);
        $this->coupon_discount = round($total_coupon_discount, 2);
        $this->amount_after_discount = round($this->amount_before_discount - $total_coupon_discount -  $total_period_discount, 2);
        $this->residual_amount =  round(($this->amount_after_discount + $this->vat_amount) - $total_paid, 2);
        $this->payment_date = Carbon::today();
        $this->payment_status = $this->residual_amount <= 1 ? 1 : 0;
        $this->save();

        if ($this->is_contract_payment) {
            if ($this->residual_amount <= 1) {
                # set contract to done
                $contract->status = 1;
            } else {
                # set contract to under processing 
                $contract->status = 0;
            }
        }

        return $contract->update_total_payments();
    }
}
