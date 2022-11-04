<?php

namespace App\Models;

use App\Exceptions\SystemConfigurationError;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester_name',
        'semester_start',
        'semester_end',
        'semester_in_fees',
        'semester_out_fees',
        'year_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'semester_start' => 'date',
        'semester_end' => 'date',
    ];
}
