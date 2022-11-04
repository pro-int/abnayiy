<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractTerms extends Model
{
    use HasFactory;
    protected $fillable = ['content','version','is_default','created_by','updated_by'];
}
