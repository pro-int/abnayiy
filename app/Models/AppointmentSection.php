<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentSection extends Model
{
    use HasFactory;
    protected $fillable = ['section_name','max_day_to_reservation'];

    public function offices()
    {
        return $this->belongsToMany(AppointmentOffice::class);
    }
    
    public static function sections()
    {
        return AppointmentSection::pluck('section_name', 'id')->toArray();
    }
}