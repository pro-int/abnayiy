<?php

namespace App\Providers;

use App\Events\WalletTransactionCreatedListener;
use App\Models\guardian;
use App\Models\PaymentAttempt;
use App\Models\Student;
use App\Models\User;
use App\Observers\GuardianObserver;
use App\Observers\PaymentAttemptObserver;
use App\Observers\StudentObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Bavix\Wallet\Internal\Events\BalanceUpdatedEventInterface;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        BalanceUpdatedEventInterface::class => [
            WalletTransactionCreatedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
        Student::observe(StudentObserver::class);
        guardian::observe(GuardianObserver::class);
        PaymentAttempt::observe(PaymentAttemptObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
