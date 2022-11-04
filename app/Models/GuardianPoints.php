<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuardianPoints extends Model
{
    use HasFactory;

    protected $fillable = [
        'guardian_id',
        'academic_year_id',
        'period_id',
        'points',
        'reason',
    ];


    public static function boot() 
    {
	    parent::boot();

        self::created(function($item)
        {
            $item->updatePointsBalance();
        });

	    self::updated(function($item) {
            if($item->isDirty('points')) {
                $item->updatePointsBalance();
            }
	    });

        self::deleted(function($item)
        {
            $item->updatePointsBalance();
        });
	}

    protected function updatePointsBalance()
    {
        $guardian = guardian::find($this->guardian_id);
        if ($guardian) {
            $balance = GuardianPoints::where('guardian_id', $this->guardian_id)->sum('points');
            
            $guardian->points_balance = $balance ?? 0;
            $guardian->save();
        }
    }

}
