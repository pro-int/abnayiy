<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_name',
        'school_id',
        'type_name_noor',
        'created_by',
        'updated_by',
        'active'
    ];

    public function genders()
    {
        return $this->hasMany(Gender::class);
    }

    public function ScopeCreatorName($query)
    {
        $query->leftJoin('users as createAdmin', 'createAdmin.id', 'types.created_by');
    }

    public function ScopeUpdaterName($query)
    {
        $query->leftJoin('users as updateAdmin', 'updateAdmin.id', 'types.updated_by');
    }

    public function ScopeSchoolName($query)
    {
        $query->leftJoin('schools', 'schools.id', 'types.school_id');
    }


    public static function types($returnArray = true, $school_id = null)
    {  
        $types = Type::where('active',1)->orderBy('id');

        if (null !== $school_id) {
            $types = $types->where('id',$school_id);
        }
        
        if ($returnArray) {
            return $types->pluck('type_name','id')->toArray();
        }
        
        return Type::select('type_name','id')->get();
    }
}
