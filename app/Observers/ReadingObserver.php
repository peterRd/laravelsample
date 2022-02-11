<?php

namespace App\Observers;

use App\Models\Reading;

class ReadingObserver
{
    /**
     * Handle the Reading "created" event.
     *
     * @param  \App\Models\Reading  $reading
     * @return void
     */
    public function created(Reading $reading)
    {
        //
    }

    /**
     * Handle the Reading "updated" event.
     *
     * @param  \App\Models\Reading  $reading
     * @return void
     */
    public function updated(Reading $reading)
    {
        //
    }

    /**
     * Handle the Reading "deleted" event.
     *
     * @param  \App\Models\Reading  $reading
     * @return void
     */
    public function deleted(Reading $reading)
    {
        //
    }

    /**
     * Handle the Reading "restored" event.
     *
     * @param  \App\Models\Reading  $reading
     * @return void
     */
    public function restored(Reading $reading)
    {
        //
    }

    /**
     * Handle the Reading "force deleted" event.
     *
     * @param  \App\Models\Reading  $reading
     * @return void
     */
    public function forceDeleted(Reading $reading)
    {
        //
    }
}
