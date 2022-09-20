<?php

declare(strict_types=1);

namespace App\Http\ViewResources\Shop\Auth;

use App\Constants\Sessions\ShopSessions;
use App\Http\ViewResources\Base\BaseViewResource;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class VerifyEmailIndexViewResource extends BaseViewResource
{
    public bool $isVerificationLinkResent;

    public ?CarbonImmutable $atVerificationLinkSent;

    public static function make(Request $request): self
    {
        $vd = new self($request);

        $vd->isVerificationLinkResent = $request->session()->get(
            ShopSessions::VERIFY_EMAIL_VERIFICATION_LINK_RESENT, false);
        $vd->atVerificationLinkSent = CarbonImmutable::make($request->session()->get(
            ShopSessions::VERIFY_EMAIL_VERIFICATION_LINK_SENT_AT, null));

        if ($vd->isVerificationLinkResent) {
            if ($vd->successMessage === null) {
                $vd->successMessage = trans('messages.verify_email.message_resent_new_link');
            }
        }

        return $vd;
    }

    public function getSentMessage() : string
    {
        return trans('messages.verify_email.message_sent.shop');
    }
    public function getSentDateTimeMessage() : ?string
    {
        if ($this->atVerificationLinkSent === null) {
            return null;
        }
        return sprintf('(%s)', $this->atVerificationLinkSent->toDateTimeString());
    }

    public function getTitle(): string
    {
        return '仮登録完了';
    }
}
