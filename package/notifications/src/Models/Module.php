<?php

namespace Gtech\AbnayiyNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Gtech\AbnayiyNotification\Models\NotificationType;


class Module extends Model
{
    use HasFactory;
    
    protected $fillable=['namespace_model','model_name','active'];
    
    // public static function modules()
    // {
    //     return Module::pluck('model_name','id')->toArray();
    // }


}
