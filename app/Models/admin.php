<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'job_title',
        'active'
    ];

    protected $primaryKey = "admin_id";

    public function attendance_manager()
    {
        return $this->hasMany(AttendanceManager::class, 'admin_id');
    }

    public function application_manager()
    {
        return $this->hasMany(ApplicationManager::class, 'admin_id');
    }
}
