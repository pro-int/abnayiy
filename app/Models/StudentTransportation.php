<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTransportation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'transportation_id',
        'transaction_id',
        'payment_type',
        'contract_id',
        'base_fees',
        'vat_amount',
        'total_fees',
        'expire_at',
        'add_by'
    ];


    protected $casts = [
        'expire_at' => 'date'
    ];
}
