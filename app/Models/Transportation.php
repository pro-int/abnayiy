<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    use HasFactory;

    protected $fillable = [
        'transportation_type',
        'annual_fees',
        'semester_fees',
        'monthly_fees',
        'active',
        'add_by',
    ];

    public static function transportations($returnArray = true, $id = 0)
    {
        if ($id > 0) {
            return Transportation::findOrFail($id);
        }

        if ($returnArray) {
            return Transportation::orderBy('id')->pluck('transportation_type','id')->toArray();
        }
        return Transportation::orderBy('id')->where('active',1)->select('transportation_type','id')->get();
    }

    public static function payment_plans($value = null)
    {
        $payment_plans = [
            1 => 'سنوي',
            2 => 'فصل دراسي',
            3 => 'شهري',
        ];

        return null !== $value ? $payment_plans[$value] : $payment_plans;
    }
}
