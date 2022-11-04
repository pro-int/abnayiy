<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class officeSchedule extends Model
{
    use HasFactory;
    protected $fillable = ['day_of_week','time_from','time_to','office_id','active'];
   
    public static function daysArray($day = null)
    {

        $days = [
           '0'=>'الاحد',
           '1'=>'الاثنين',
           '2'=>'الثلاثاء',
           '3'=>'الاربعاء',
           '4'=>'الخميس',
           '5'=>'الجمعه',
           '6'=>'السبت',
        ];

        if (null !== $day && array_key_exists($day,$days)) {
            return $days[$day];
        }
        return $days;
    }  

}
