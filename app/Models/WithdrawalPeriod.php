<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_name',
        'apply_start',
        'apply_end',
        'academic_year_id',
        'fees_type',
        'fees',
        'active',
    ];

    protected $dates = [
        'apply_start',
        'apply_end',
    ];
}
