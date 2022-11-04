<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'attended',
        'comment',
        'online',
        'online_url',
        'handled_by',
        'admin_id',
        'application_id',
        'appointment_id'
    ];

    public function getInternalUrl()
    {
        return route('applications.index',http_build_query(['search'=> $this->application_id]));
    }
}
