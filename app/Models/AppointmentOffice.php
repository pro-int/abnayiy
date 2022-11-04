<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentOffice extends Model
{
    use HasFactory;
    protected $fillable = ['office_name','employee_name','phone'];

    public function sections()
    {
        return $this->belongsToMany(AppointmentSection::class, 'section_has_offices');
    }

    public Static function offices()
    {
        return AppointmentOffice::pluck('office_name','id')->toArray();
    }
}
