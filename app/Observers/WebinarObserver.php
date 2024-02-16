<?php

namespace App\Observers;

use App\Models\Group;
use App\Models\Webinar;
use Illuminate\Support\Facades\Log;

class WebinarObserver
{
    /**
     * Handle the Webinar "created" event.
     */
    public function created(Webinar $webinar): void
    {
        Group::create([
            'webinar_id' => $webinar->id,
            'name' => $webinar->name,
        ]);
    }

    /**
     * Handle the Webinar "updated" event.
     */
    public function updated(Webinar $webinar): void
    {

    }

    /**
     * Handle the Webinar "deleted" event.
     */
    public function deleted(Webinar $webinar): void
    {
        //
    }

    /**
     * Handle the Webinar "restored" event.
     */
    public function restored(Webinar $webinar): void
    {
        //
    }

    /**
     * Handle the Webinar "force deleted" event.
     */
    public function forceDeleted(Webinar $webinar): void
    {
        //
    }
}
