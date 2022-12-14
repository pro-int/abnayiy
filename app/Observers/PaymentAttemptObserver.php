<?php

namespace App\Observers;

use App\Http\Traits\OdooIntegrationTrait;
use App\Models\PaymentAttempt;

class PaymentAttemptObserver
{
    use OdooIntegrationTrait;

    /**
     * Handle the PaymentAttempt "created" event.
     *
     * @param  \App\Models\PaymentAttempt  $paymentAttempt
     * @return void
     */
    public function created(PaymentAttempt $paymentAttempt)
    {
    }

    /**
     * Handle the PaymentAttempt "updated" event.
     *
     * @param  \App\Models\PaymentAttempt  $paymentAttempt
     * @return void
     */
    public function updated(PaymentAttempt $paymentAttempt)
    {
        //$this->createPaymentInOdoo($paymentAttempt->getOdooKeys());
    }

    /**
     * Handle the PaymentAttempt "deleted" event.
     *
     * @param  \App\Models\PaymentAttempt  $paymentAttempt
     * @return void
     */
    public function deleted(PaymentAttempt $paymentAttempt)
    {
        //
    }

    /**
     * Handle the PaymentAttempt "restored" event.
     *
     * @param  \App\Models\PaymentAttempt  $paymentAttempt
     * @return void
     */
    public function restored(PaymentAttempt $paymentAttempt)
    {
        //
    }

    /**
     * Handle the PaymentAttempt "force deleted" event.
     *
     * @param  \App\Models\PaymentAttempt  $paymentAttempt
     * @return void
     */
    public function forceDeleted(PaymentAttempt $paymentAttempt)
    {
        //
    }
}
