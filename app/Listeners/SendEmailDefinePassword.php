<?php

namespace ChatShopping\Listeners;

use ChatShopping\Events\UserCreatedEvent;
use ChatShopping\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailDefinePassword
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreatedEvent  $event
     * @return void
     */
    public function handle(UserCreatedEvent $event)
    {
        /** @var User $user */
        $user = $event->getUser();
        $token = \Password::broker()->createToken($user);

        $user->sendPasswordResetNotification($token);
        //usando notificação personalizada criada com:
        //php artisan make:nofication MyResetPassword
        //$user->notify(new MyResetPassword($token));
    }
}
