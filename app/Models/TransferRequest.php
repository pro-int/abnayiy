<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuition_fee',
        'tuition_fee_vat',
        'period_discount',
        'minimum_tuition_fee',

        'bus_fees',
        'bus_fees_vat',

        'total_debt',
        'minimum_debt',
        'dept_paid',

        'total_paid',
        'contract_id',
        'next_school_year_id',
        'academic_year_id',
        'next_level_id',
        'plan_id',
        'period_id',
        'payment_ref',
        'approved_by_admin',
        'payment_method_id',
        'transportation_id',
        'transportation_payment',
        'status'
    ];

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($iten) {
            if ($iten->status !== 'complete') {
                $requests = TransferRequest::whereIn('status', ['new', 'pending', 'complete'])->where('contract_id', $iten->contract_id)->where('id', '!<>', $iten->id)->get();
                if (!count($requests)) {
                    $contract = Contract::find($iten->contract_id);
                    if ($contract) {
                        $contract->updateQuietly(['status' => 1]);
                    }
                }
            }
        });
    }

    public function getStatus($onlytext = false)
    {
        switch ($this->status) {
            case 'new':
                $status = 'طلب جديد';
                $color = 'primary';
                break;
            case 'pending':
                $status = 'بأنتظار التأكيد';
                $color = 'warning';
                break;
            case 'complete':
                $status = 'مدفوع';
                $color = 'success';
                break;
            case 'NoPayment':
                $status = 'فشل الدفع';
                $color = 'danger';
                break;
            case 'expired':
                $status = 'منتهي الصلاحية';
                $color = 'danger';
                break;
            default:
                $status = 'غير محدد';
                $color = 'dark';
                break;
        }

        return $onlytext ? ['status' => $status, 'class' => $color] : sprintf('<span class="badge bg-%s">%s</span>', $color, $status);
    }
}
