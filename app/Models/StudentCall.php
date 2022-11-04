<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCall extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'call_date'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        // 'call_date' => 'datetime',
    ];
}
