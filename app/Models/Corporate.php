<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Corporate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'corporate_name',
        'created_by',
        'updated_by',
        'active'
    ];

    public function schools()
    {
        return $this->hasMany(School::class);
    }
    

    /**
     * return only active Corporates
     */
    protected function ScopeActive($query)
    {
        $query->where('active',true);
    }

    protected function ScopeCreatorName($query)
    {
        $query->leftJoin('users as createAdmin', 'createAdmin.id', 'corporates.created_by');
    }

    protected function ScopeUpdaterName($query)
    {
        $query->leftJoin('users as updateAdmin', 'updateAdmin.id', 'corporates.updated_by');
    }
}
