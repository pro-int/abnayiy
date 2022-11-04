<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'grade_id'
    ];
    protected $primaryKey = "admin_id";

    protected $casts = [
        'grade_id' => 'array', // Will convarted to (Array)
        // 'email_verified_at' => 'datetime',
    ];
    
}
