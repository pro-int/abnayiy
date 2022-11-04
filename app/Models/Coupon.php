<?php

namespace App\Models;

use App\Events\UpdateDiscount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'coupon_value',
        'level_id',
        'academic_year_id',
        'available_at',
        'expire_at',
        'used_coupon',
        'used_value',
        'coupon_type',
        'classification_id',
        'active',
        'add_by',
    ];

    public static function boot()
    {
        parent::boot();
        static::created(function ($item) {
            dispatch(new UpdateDiscount($item->level_id, $item->academic_year_id));
        });

        static::updated(function ($item) {
            dispatch(new UpdateDiscount($item->level_id, $item->academic_year_id));
        });

        static::deleted(function ($item) {
            dispatch(new UpdateDiscount($item->level_id, $item->academic_year_id));
        });
    }

    protected $casts = [
        'expire_at' => 'datetime', // Will convarted to (Array)
        'available_at' => 'datetime',
    ];

    public function categories()
    {
        return $this->hasMany(CouponCategory::class);
    }

    public function usage()
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function isUsed()
    {
        if ($this->used_coupon) {
            $data['icon'] = 'check-circle';
            $data['class'] = 'success';
        } else {
            $data['icon'] = 'x-circle';
            $data['class'] = 'warning';
        }
        return sprintf('<em class="text-%s"data-feather="%s"></em>', $data['class'], $data['icon']);
    }

    public function getType($returnArray = false)
    {
        $data = $this->coupon_type == 'special' ? ['warning','خصومات خاصة'] : ['success','خصومات عامة'];
        return $returnArray ? $data : sprintf('<span class="badge bg-%s">%s</span>',$data[0],$data[1]);
    }
    
}
