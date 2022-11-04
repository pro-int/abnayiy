<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservedAppointment extends Model
{
    use HasFactory;

    public $modelNotFoundMessage = "The user was not found";

    protected $fillable = [
        'selected_date',
        'online',
        'office_id', 
        'comment',
        'attended',
        'admin_id',
        'online_url',
        'handled_by',
        'section_id',
        'appointment_time',
    ];
}
