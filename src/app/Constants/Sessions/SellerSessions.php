<?php
declare(strict_types=1);

namespace App\Constants\Sessions;

final class SellerSessions
{
    private function __construct()
    {
    }

    // VERIFY_EMAIL
    public const VERIFY_EMAIL_VERIFICATION_LINK_RESENT = 'seller.verify_email.verification_link_resent';
    public const VERIFY_EMAIL_VERIFICATION_LINK_SENT_AT = 'seller.verify_email.verification_link_sent_at';
    public const VERIFY_EMAIL_TARGET_EMAIL = 'seller.verify_email.target_email';

    // AUTH_GOOGLE
    public const AUTH_GOOGLE_APP_ACTION = 'seller.auth.google.app_action';

    // SUCCESS
    public const SUCCESS_MESSAGE = CommonSessions::SUCCESS_MESSAGE;


}
