<?php

namespace ChatShopping\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'ChatShopping\Events\Event' => [
            'ChatShopping\Listeners\EventListener',
        ],
        'ChatShopping\Events\UserCreatedEvent' => [
            'ChatShopping\Listeners\SendEmailDefinePassword'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
