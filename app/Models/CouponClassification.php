<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class CouponClassification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'classification_prefix',
        'classification_name',
        'academic_year_id',
        'allowed_types',
        'unused_limit',
        'color_class',
        'used_limit',
        'admin_id',
        'active',
        'limit',
    ];

        /**
     * @var array
     */
    protected $casts = [
        'allowed_types' => 'array',
    ];

    public function setClassificationPrefixAttribute($value)
    {
        $this->attributes['classification_prefix'] = strtoupper($value);
    }
}
