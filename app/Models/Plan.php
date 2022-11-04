<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    const PLAN_BASE = [
        'total' => 'إجمالي الرسوم','semester' => 'الفصل الدراسي','selected_date' => 'اقساط'
    ];

    protected $fillable = [
        'plan_name',
        'req_confirmation',
        'fixed_discount',
        'plan_based_on',
        'payment_due_determination',
        'beginning_installment_calculation',
        'down_payment',
        'active',
        'transaction_methods',
        'contract_methods'
    ];

    public static function plans()
    {
        return Plan::orderBy('id')->pluck('plan_name', 'id')->toArray();
    }

    protected $casts = [
        'transaction_methods'  => 'array',
        'contract_methods'  => 'array'
    ];
}
