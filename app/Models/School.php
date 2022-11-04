<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'school_name',
        'corporate_id',
        'created_by',
        'updated_by',
        'active'
    ];

    public function corporate()
    {
        return $this->belongsTo(corporate::class);
    }

    public function genders()
    {
        return $this->hasMany(Gender::class);
    }

    public function ScopeCreatorName($query)
    {
        $query->leftJoin('users as createAdmin', 'createAdmin.id', 'schools.created_by');
    }
    
    public function ScopeUpdaterName($query)
    {
        $query->leftJoin('users as updateAdmin', 'updateAdmin.id', 'schools.updated_by');
    }
    
    public function ScopeCorporateName($query)
    {
        $query->leftJoin('corporates', 'corporates.id', 'schools.corporate_id');
    }

    public function ScopeSelectedCorporate($query)
    {
        if ($corporate  = session('seleted_corprate')) {
            $query->where('corporate_id',$corporate->id);
        }
    }
    
    /**
     * return only active Corporates
     */
    protected function ScopeActive($query)
    {
        $query->where('active', true);
    }
    
    public function ScopeFiltered($query)
    {
        if (request('corporate')) {
           $query->where('corporate_id', request('corporate'));
        }
    }
}
