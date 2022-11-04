<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoorQueue extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_name',
        'job_type',
        'class_id',
        'grade_id',
        'job_status',
        'job_result',
        'file_path',
        'noor_account_id',
        'grade_id'
    ];
}
