<?php

namespace App\Models;

use App\Exceptions\SystemConfigurationError;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_name',
        'apply_start',
        'apply_end',
        'academic_year_id',
        'points_effect',
        'active',
    ];

    protected $dates = [
        'apply_start',
        'apply_end',
    ];

}
