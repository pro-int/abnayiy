<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NoorAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_name',
        'username',
        'password',
        'school_name',
        'created_by',
        'updated_by'
    ];

    protected static function accounts()
    {
        return NoorAccount::select('id',DB::raw('CONCAT(username, " (" , account_name, ")") as account'))->pluck('account','id')->toArray();
    }
}
