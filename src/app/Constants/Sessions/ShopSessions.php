<?php
declare(strict_types=1);

namespace App\Constants\Sessions;

final class ShopSessions
{
    private function __construct()
    {
    }

    public const VERIFY_EMAIL_VERIFICATION_LINK_RESENT = 'shop.verify_email.verification_link_resent';
    public const VERIFY_EMAIL_VERIFICATION_LINK_SENT_AT = 'shop.verify_email.verification_link_sent_at';

    public const SUCCESS_MESSAGE = CommonSessions::SUCCESS_MESSAGE;


}
