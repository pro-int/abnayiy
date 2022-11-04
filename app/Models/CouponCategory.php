<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCategory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'coupon_id',
        'category_id',
    ];

    public static function wipe_coupon_data($coupon_id)
    {
        return CouponCategory::where('coupon_id', $coupon_id)->delete();
    }
}
