<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'gender_id',
        'grade_id',
        'level_name',
        'level_name_noor',
        'tuition_fees',
        'min_students',
        'coupon_discount_persent',
        'period_discount_persent',
        'academic_year_id',
        'next_level_id',
        'is_graduated',
        'active'
    ];

    public static function levels($returnArray = true, $grade_id = null)
    {
        $levels = Level::where('active',1);
        if (null !== $grade_id) {
            $levels = $levels->where('grade_id', $grade_id);
        }

        if ($returnArray) {
            return $levels->pluck('level_name', 'id')->toArray();
        }

        return $levels->select('grade_id','level_name', 'id')->get();

    }

    public function classrooms()
    {
        return $this->hasMany(ClassRoom::class);
    }

    public static function tuition_fees($level_id, $semesters)
    {
        $persent = $semesters->sum('semester_in_fees');
    
        $level = Level::find($level_id);

        return round($level->tuition_fees * ($persent / 100),2);
    }
}
