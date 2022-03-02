<?php

namespace App\Listeners;

use App\Events\NotifySubscribedUser;
use App\Events\PhotosReceived;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotification implements ShouldQueue
{
    public $queue = 'notifications';

    /**
     * Handle the event. We have been notified that there are new photos to be disseminated. Fetch subscribed users
     * and dispatch another event.
     *
     * @param  \App\Events\PhotosReceived  $event
     * @return void
     */
    public function handle(PhotosReceived $event)
    {
        $users = [2]; // Fetch all users from DB that have subscribed to the event.
        foreach ($users as $user) {
            NotifySubscribedUser::dispatch($user, $event->photos);
        }
    }
}
