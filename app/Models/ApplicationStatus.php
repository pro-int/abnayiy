<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    use HasFactory;

    protected $fillable = [];

    public static function Statuses($return_array = true,$id = null)
    {
        if(null !== $id) {
            return ApplicationStatus::select('status_name')->find($id);
        }
        if ($return_array) {
            return ApplicationStatus::orderBy('id')->pluck('status_name', 'id')->toArray();
        }
        return ApplicationStatus::orderBy('id')->select('status_name', 'id','color')->get();
    }
}
