<?php

namespace App\Models;

use App\Http\Traits\ContractTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'academic_year_id',
        'reason',
        'date',
        'comment',
        'amount_fees',
        'transportation_fees',
        'application_status',
        'school_name'
    ];


    public static function getWithdrawalReasons(){
        return [
            "تغيير محل الإقامة" => "تغيير محل الإقامة",
            "الرسوم الدراسية" => "الرسوم الدراسية",
            "أسباب تعليمية" => "أسباب تعليمية",
            "أخرى" => "أخرى",
        ];
    }

}
