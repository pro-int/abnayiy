<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'coupon_id' ,
        'guardian_id' ,
        'student_id' ,
        'tranaction_id',
        'used_at',
    ];
}
