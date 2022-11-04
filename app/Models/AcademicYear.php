<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicYear extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'year_numeric',
        'year_name',
        'year_hijri',
        'year_start_date',
        'year_end_date',
        'start_transition',
        'current_academic_year',
        'previous_year_id',
        'fiscal_year_end',
        'is_open_for_admission',
        'min_tuition_percent',
        'installments_available_until',
        'last_installment_date',
        'min_debt_percent'
    ];

    public static function years($ignore = [])
    {
        return AcademicYear::whereNotIn('id', $ignore)->orderBy('id', 'desc')->pluck('year_name', 'id')->toArray();
    }

    public function fiscalYearStatus()
    {
        return !is_null($this->fiscal_year_end) &&  $this->fiscal_year_end >= Carbon::now();
    }

    /**
     * @var array
     */
    protected $casts = [
        'fiscal_year_end' => 'date',
        'year_start_date' => 'date',
        'year_end_date' => 'date',
        'last_installment_date' => 'date'
    ];
}
