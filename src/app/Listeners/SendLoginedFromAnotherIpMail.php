<?php

namespace App\Listeners;

use App\Mail\LoginedFromAnotherIpMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\LoginedAnotherIpAddress;
use Illuminate\Support\Facades\Mail;

class SendLoginedFromAnotherIpMail
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
     * @param LoginedAnotherIpAddress $event
     * @return void
     */
    public function handle(LoginedAnotherIpAddress $event)
    {
        \Log::debug('SendLoginedFromAnotherIpMail.handle', ['event' => $event]);
        // TODO 非同期
        $mailAddr = $event->request->input('email');
        Mail::to($mailAddr)->send(new LoginedFromAnotherIpMail($mailAddr));
    }
}
