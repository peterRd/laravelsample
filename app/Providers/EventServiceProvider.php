<?php

namespace App\Providers;

use App\Events\NotifySubscribedUser;
use App\Events\PhotosReceived;
use App\Listeners\SendNotification;
use App\Listeners\SendUserNotification;
use App\Models\Reading;
use App\Observers\ReadingObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PhotosReceived::class => [
            SendNotification::class
        ],
        NotifySubscribedUser::class => [
            SendUserNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Reading::observe(ReadingObserver::class);
    }
}
