<?php

namespace App\Mail;

use App\Data\Common\EmailAddress;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerMailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    private EmailAddress $userEmail;
    private string $verificationUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EmailAddress $userEmail, $verificationUrl)
    {
        $this->userEmail = $userEmail;
        $this->verificationUrl = $verificationUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(config('mail.from.address'))
            ->subject('メールアドレスの確認')
            ->view('mail.seller-email-verification')
            ->with([
                'mailAddr' => $this->userEmail->getString(),
                'verificationUrl' => $this->verificationUrl,
            ]);
    }
}
