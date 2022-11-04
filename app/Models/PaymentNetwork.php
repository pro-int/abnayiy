<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentNetwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'network_name',
        'account_number',
        'active',
        'add_by'
    ];
   
}
