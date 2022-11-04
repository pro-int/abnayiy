<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ConfirmPassword;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where($this->username($request), $request->username)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
        });
        Fortify::username(function () {
            return config('fortify.ConfirmationUserName', 'email');
        });

        RateLimiter::for('login', function (Request $request) {
            $username = (string) $request->username;
            return Limit::perMinute(5)->by($username . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function username(Request $request)
    {
        if (filter_var($request->get('username'), FILTER_VALIDATE_EMAIL)) {
            return 'email';
        } else {
            return 'phone';
        }
    }

    public function confirmPassword($user, $password, StatefulGuard $guard)
    {
        return $guard->validate([
            'email' => $user->email,
            'password' => $password,
        ]);
    }
}
