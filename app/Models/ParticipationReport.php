<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipationReport extends Model
{
    use HasFactory;

    public function marks()
    {
        return $this->hasMany(StudentParticipation::class,'report_id');
    }
}
