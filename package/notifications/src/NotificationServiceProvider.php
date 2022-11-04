<?php

namespace Gtech\AbnayiyNotification;

use Gtech\AbnayiyNotification\Models\UserNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{

    /**
     * Register any application Notification services.
     *
     * @return void
     */

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/abnayiynotifications.php', 'abnayiynotifications'
        );
    }

    /**
     * Bootstrap any application Notification services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->loadViewsFrom(__DIR__ . '/../views', 'Notification');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

    }

     /**
     * register routes
     *
     * @return Route
     */
    protected function registerRoutes()
    {
        Route::group($this->adminRouteConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__. '/../routes/admin.php');
        });

        Route::group($this->apiRouteConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__. '/../routes/api.php');
        });
    }

    /**
     * get route configration settings
     *
     * @return array
     */
    protected function adminRouteConfiguration()
    {
        return [
            'prefix' => config('abnayiynotifications.admin_prefix'),
            'middleware' => config('abnayiynotifications.admin_middleware'),
        ];
    }

        /**
     * get route configration settings
     *
     * @return array
     */
    protected function apiRouteConfiguration()
    {
        return [
            'prefix' => config('abnayiynotifications.api_prefix'),
            'middleware' => config('abnayiynotifications.api_middleware'),
        ];
    }
}
