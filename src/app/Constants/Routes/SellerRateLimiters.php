<?php

namespace App\Constants\Routes;

final class SellerRateLimiters
{
    private function __construct()
    {
    }

    const VERIFY_EMAIL_SEND = 'verify_email_send';
    const VERIFY_EMAIL_VERIFY = 'verify_email_verify';
    const REGISTRATION = 'registration';
}
