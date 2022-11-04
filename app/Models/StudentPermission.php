<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'pickup_persion',
        'pickup_time',
        'permission_reson',
        'permission_duration',
        'approved_by',
        'case_id'
    ];

    protected $dates = [
        'pickup_time'
    ];
}
