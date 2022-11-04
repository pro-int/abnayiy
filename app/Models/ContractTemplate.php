<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractTemplate extends Model
{
    use HasFactory;

    public static $default_water_mark_path = 'assets/reportLogo45d.png';
    public static $default_logo_path = 'assets/logo-removebg-preview.png';
}
