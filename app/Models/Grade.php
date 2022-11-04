<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'gender_id',
        'grade_name',
        'grade_name_noor',
        'appointment_section_id',
        'noor_account_id',
        'active'
    ];

    public function levels()
    {
        return $this->hasMany(Level::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function ScopeCreatorName($query)
    {
         $query->leftJoin('users as createAdmin', 'createAdmin.id', 'grades.created_by');
    }

    public function ScopeUpdaterName($query)
    {
         $query->leftJoin('users as updateAdmin', 'updateAdmin.id', 'grades.updated_by');
    }

    public function ScopeGenderName($query)
    {
         $query->leftJoin('genders', 'genders.id', 'grades.gender_id');
    }

    public function getFiltered(array $filters): Collection
    {
        return $this
            ->CreatorName()->UpdaterName()->GenderName()
            ->select(
                'grades.*',
                DB::raw('CONCAT(createAdmin.first_name, " " , createAdmin.last_name) as createdAdminName'),
                DB::raw('CONCAT(updateAdmin.first_name, " " , updateAdmin.last_name) as UpdatedAdmimName'),
                'appointment_sections.section_name',
                'noor_accounts.account_name'
            )
            ->leftjoin('appointment_sections', 'appointment_sections.id', 'grades.appointment_section_id')
            ->leftjoin('noor_accounts', 'noor_accounts.id', 'grades.noor_account_id')
            ->filter($filters, 'gender_id', 'gender')
            ->filter($filters, 'school_id', 'gender.school')
            ->with('gender', 'gender.school')->get();
    }

    public function scopeFilter($query, array $filters, string $key, string $relation, string $column = 'id')
    {
        return $query->when(array_key_exists($key, $filters), function ($q) use ($filters, $relation, $column, $key) {
            $q->whereRelation($relation, $column, $filters[$key]);
        });
    }


    public static function grades($returnArray = true, $gender_id = null)
    {
        $gender =  Grade::where('active', 1);
        if (null !== $gender_id) {
            $gender = $gender->where('gender_id', $gender_id);
        }
        if ($returnArray) {
            return $gender->pluck('grade_name', 'id')->toArray();
        }
        return $gender->select('gender_id', 'grade_name', 'id')->get();
    }
}
