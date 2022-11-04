<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    protected $fillable = ['class_name','class_name_noor','level_id','academic_year_id','active'];

    public function students()
    {
        return $this->hasManyThrough(Student::class,Contract::class,'class_id','id',null,'student_id');
    }

    public static function classes($returnArray = true, $class_id = null)
    {
        if (null !== $class_id) {
            if (is_array($class_id)) {
                return ClassRoom::whereIn('id',$class_id)->pluck('class_name')->toArray();
            }
            return ClassRoom::pluck('class_name','id')->toArray();
        }
        if($returnArray) {
            return ClassRoom::pluck('class_name','id')->toArray();
        }
    }
}
