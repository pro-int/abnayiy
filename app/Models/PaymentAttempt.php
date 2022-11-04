<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PaymentAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'payment_method_id',
        'requested_ammount',
        'received_ammount',
        'approved',
        'reference',
        'reason',
        'coupon',
        'coupon_discount',
        'period_id',
        'bank_id',
        'payment_network_id',
        'period_discount',
        'attach_pathh',
        'guardian_id',
        'admin_id',
    ];


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($item) {
            if (! is_null($item->reference) && Storage::exists($item->reference)) {
                Storage::unlink($item->reference);
            }
        });
    }

    public function getInternalUrl()
    {
        $transaction = transaction::select('transactions.id', 'transactions.contract_id','contracts.student_id')
            ->leftjoin('contracts', 'contracts.id', 'transactions.contract_id')
            ->where('transactions.id', $this->transaction_id)
            ->first();

        if ($transaction) {
            return route('students.contracts.transactions.attempts.index', ['student' => $transaction->student_id, 'contract' => $transaction->contract_id, 'transaction' => $transaction->id]);
        } else {
            return '';
        }
    }

    public function approved()
    {
        $status = [
            'بأنتظار التأكيد',
            'مدفوع',
            'فشل الدفع',
        ];

        return isset($status[$this->approved]) ? $status[$this->approved] : 'غير معروف';
    }

    public static function PindngPayments()
    {
        return Cache::remember('PindngPayments', 30, function () {
            return PaymentAttempt::where('approved', 0)->whereIn('payment_method_id', PaymentMethod::where('require_approval', 1)->pluck('id')->toArray())->count();
        });
    }
}
