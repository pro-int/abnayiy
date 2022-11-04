<?php

namespace App\Models;

use Gtech\AbnayiyNotification\Models\UserNotificationSetting;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'country_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    //relations 

    public static function boot() 
    {
	    parent::boot();

        self::deleting(function ($user) {
            $user->roles()->detach();
            $user->admin && $user->admin->delete();
            $user->teacher && $user->teacher->delete();
            $user->guardian && $user->guardian->delete();
        });

	    self::created(function($user) {
           $user->userAutoNotificationSubscribe();
	    });
	}

    public function getFullName(String $div = ' ' )
    {
        return $this->first_name . $div . $this->last_name;
    }
    public function guardian()
    {
        return $this->hasOne(guardian::class, 'guardian_id');
    }

    public function admin()
    {
        return $this->hasOne(admin::class, 'admin_id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'teacher_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Create default settings for notifications
     * @return void
     */
    public function userAutoNotificationSubscribe() : void
    {
        UserNotificationSetting::create([
            'user_id' => $this->id,
            'channels' => [1]
        ]);
    }
}
