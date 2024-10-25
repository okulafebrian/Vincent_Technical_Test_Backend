<?php

namespace App\Listeners;

use App\Events\ClientAccountCreated;
use App\Mail\WelcomeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
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
    public function handle(ClientAccountCreated $event): void
    {
        $user = $event->user;

        Mail::to($user->email)->send(new WelcomeEmail($user));
    }
}
