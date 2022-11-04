<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionsCategory extends Model
{
    use HasFactory;
    
    public function permissions()
    {
       return $this->hasMany(Permissions::class,'permission_category_id');
    }
}
