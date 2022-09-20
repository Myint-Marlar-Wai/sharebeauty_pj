<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginedFromAnotherIpMail extends Mailable
{
    use Queueable, SerializesModels;

    private $userEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // TODO 非同期、そして形式を揃える
        return $this
            ->from(config('mail.from.address'))
            ->subject('前回と違うIPアドレスからログインしましたか？')
            ->view('mail.logined-another-ip')
            ->with(['mailAddr' => $this->userEmail]);
    }
}
