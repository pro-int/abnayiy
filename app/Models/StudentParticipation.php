<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParticipation extends Model
{
    use HasFactory;

    protected $fillabel = [
        'student_id',
        'home_work',
        'participation',
        'attention',
        'tools',
        'date',
        'subject_id',
        'add_by'

    ];
}
