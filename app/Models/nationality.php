<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nationality extends Model
{
    use HasFactory;

    protected $fillable = [
        'nationality_name',
        'vat_rate',
        'active'
    ];

    public static function nationalities()
    {
        return nationality::orderBy('id')->where('active',true)->pluck('nationality_name', 'id')->toArray();
    }
}
