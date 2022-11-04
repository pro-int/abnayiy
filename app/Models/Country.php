<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['country_name','country_code', 'active'];

    public function users()
    {
        return $this->hasMany(User::class);
    }


    public static function countries()
    {
        return Country::where('active',1)->pluck('country_name','id')->toArray();
    }
}
