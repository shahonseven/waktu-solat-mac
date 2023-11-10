<?php

namespace App\Listeners;

use App\Services\MalaysiaPrayerTimeService;
use Native\Laravel\Events\App\ApplicationBooted;

class InitializePrayerTimeDatabase
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ApplicationBooted $event): void
    {
        (new MalaysiaPrayerTimeService())->get(fresh: true);
    }
}
