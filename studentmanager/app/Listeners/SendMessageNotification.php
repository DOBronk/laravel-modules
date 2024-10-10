<?php

namespace App\Listeners;

use App\Events\MessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\NewMessageReceived;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SendMessageNotification implements ShouldQueue
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
    public function handle(MessageSent $event): void
    {
        Mail::to(User::find($event->message->user_id))->send(new NewMessageReceived($event->message));
    }
}
