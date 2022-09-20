<?php

namespace App\Listeners;

use App\Mail\LockOutMail;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendLockOutMailToUser
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
     * @param Lockout $event
     * @return void
     */
    public function handle(Lockout $event)
    {
        \Log::debug('SendLockOutMailToUser.handle', ['event' => $event]);
        $mailAddr = $event->request->input('email');
        Mail::to($mailAddr)->send(new LockOutMail($mailAddr));
    }
}
