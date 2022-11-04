<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;

    protected $fillabel = [
        'absent_date',
        'student_id',
        'class_id',
        'reason',
        'add_by'
    ];
}
