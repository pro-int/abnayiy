<?php

namespace Gtech\AbnayiyNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalNotification extends Model
{
    use HasFactory;

    public function getFrequentAttribute($value)
    {
        return $value == 'single' ? 'مرة واحدة' : 'متكرر';
    }

    // public function getTargetUserAttribute($value)
    // {
    //     return $value == 'admin' ? 'الأدارة' : 'المستخدم';
    // }

    protected $casts = [
        'to_notify' => 'array'
    ];
    
    
}
