<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    protected $fillable = [
        'gender_name',
        'school_id',
        'gender_type',
        'created_by',
        'updated_by',
        'active'
    ];

    protected $types = [
        0 => 'بنات',
        1 => 'بنين'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function getGenderTypeName()
    {
        return $this->types[$this->attributes['gender_type']];
    }

    public function ScopeCreatorName($query)
    {
        return $query->leftJoin('users as createAdmin', 'createAdmin.id', 'genders.created_by');
    }

    public function ScopeUpdaterName($query)
    {
        return $query->leftJoin('users as updateAdmin', 'updateAdmin.id', 'genders.updated_by');
    }

    public function ScopeSchoolName($query)
    {
        return $query->leftJoin('schools', 'schools.id', 'genders.school_id');
    }

    public function ScopeFiltered($query, $request)
    {
        if ($request->filled('school_id') && is_numeric($request->school_id)) {
            return  $query->where('types.id', $request->school_id);
        }
    }

    public static function genders($returnArray = true, $school_id = null)
    {

        $geders = Gender::where('active', 1);
        if (null !== $school_id) {
            $geders = $geders->where('school_id', $school_id);
        }

        if ($returnArray) {
            return $geders->pluck('gender_name', 'id')->toArray();
        }

        return  $geders->select('school_id', 'gender_name', 'id')->get();
    }
}
