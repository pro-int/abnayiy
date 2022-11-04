<?php

namespace App\Observers;

use App\Http\Traits\OdooIntegrationTrait;
use App\Models\guardian;

class GuardianObserver
{
    use OdooIntegrationTrait;
    /**
     * Handle the guardian "created" event.
     *
     * @param  \App\Models\guardian  $guardian
     * @return void
     */
    public function created(guardian $guardian)
    {
        //
        $this->sendDataToOdoo($guardian->getOdooKeys(), $guardian->getEnableOdooIntegration());
    }

    /**
     * Handle the guardian "updated" event.
     *
     * @param  \App\Models\guardian  $guardian
     * @return void
     */
    public function updated(guardian $guardian)
    {
        //
    }

    /**
     * Handle the guardian "deleted" event.
     *
     * @param  \App\Models\guardian  $guardian
     * @return void
     */
    public function deleted(guardian $guardian)
    {
        //
    }

    /**
     * Handle the guardian "restored" event.
     *
     * @param  \App\Models\guardian  $guardian
     * @return void
     */
    public function restored(guardian $guardian)
    {
        //
    }

    /**
     * Handle the guardian "force deleted" event.
     *
     * @param  \App\Models\guardian  $guardian
     * @return void
     */
    public function forceDeleted(guardian $guardian)
    {
        //
    }
}
