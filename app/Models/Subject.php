<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_name',
        'level_id',
        'min_grade',
        'max_grade',
        'created_by',
        'updated_by'
    ];

    public static function subjects($toArray = true)
    {
        if ($toArray) {
            return Subject::pluck('subject_name','id')->toArray();
        }
    }
}
