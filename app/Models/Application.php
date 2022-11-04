<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name',
        'national_id',
        'birth_date',
        'birth_place',
        'gender',
        'student_care',
        'level_id',
        'nationality_id',
        'gender',
        'application_id',
        'plan_id',
        'academic_year_id',
        'transportation_id',
        'transportation_payment',
        'appointment_id',
        'status_id',
        'sales_id',
        'guardian_id'
    ];

        // this is a recommended way to declare event handlers
        public static function boot() {
            parent::boot();
    
            static::deleting(function($application) { // delete meeiting method call this
                 $application->appointment()->delete();
            });
        }

    public function appointment()
    {
        return $this->hasOne(ReservedAppointment::class,'id','appointment_id');
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }


    public function getInternalUrl()
    {
        return route('applications.index',http_build_query(['search'=> $this->national_id]));
    }

}
