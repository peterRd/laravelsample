<?php

namespace App\Listeners;

use App\Events\NotifySubscribedUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Queue\InteractsWithQueue;

class SendUserNotification implements ShouldQueue, ShouldBeUnique
{
    use InteractsWithQueue;

    /**
     * @var int If the job has failed retry again for arbitary(5) times.
     */
    public $tries = 5;
    /**
     * @var User model/similar that contains notification options
     */
    public $user;
    /**
     * @var array
     */
    public $photos;
    /**
     * Get the unique identifier for the job.
     *
     * We need to make sure that users don't get issued multiple notifications in the same period.
     */
    public function uniqueId() {
        return $this->user->id;
    }
    /**
     * Determine the time at which the listener should timeout.
     *
     * @return \DateTime
     */
    public function retryUntil()
    {
        // Should relate to how often the original job is being run. In this case it's daily so with 12hrs is fine.
        return now()->addHours(12);
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NotifySubscribedUser  $event
     * @return void
     */
    public function handle(NotifySubscribedUser $event)
    {
        // Notify subscribed user via push or email notification. Collate all photos into single push/email.
    }
}
