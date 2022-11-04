<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Ripcord\Providers\Laravel\ServiceProvider::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        $ssl = env('FORCE_SSL',false); 
        if ($ssl) {
            URL::forceScheme('https');
        }

        // Storage::disk('local')->buildTemporaryUrlsUsing(function ($path, $expiration, $options) {
        //     return URL::temporarySignedRoute(
        //         'files.download',
        //         $expiration,
        //         array_merge($options, ['path' => $path])
        //     );
        // });
    }
}
