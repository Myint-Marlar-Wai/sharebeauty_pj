<?php

declare(strict_types=1);

namespace App\Http\ViewResources\Seller\Auth;

use App\Constants\Sessions\SellerSessions;
use App\Data\Common\EmailAddress;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Http\Requests\Seller\Auth\Guest\VerifyEmailIndexForGuestRequest;
use App\Http\Requests\Seller\Auth\VerifyEmailIndexRequest;
use App\Http\ViewResources\Base\BaseViewResource;
use Carbon\CarbonImmutable;

class VerifyEmailIndexViewResource extends BaseViewResource
{
    public bool $isVerificationLinkResent;

    public bool $isLoggedIn;

    public bool $canResendVerificationLink;

    public EmailAddress $email;

    public string $hidden_email;

    public ?CarbonImmutable $atVerificationLinkSent;

    public static function make(VerifyEmailIndexRequest|VerifyEmailIndexForGuestRequest $request): self
    {
        $vr = new self($request);

        if ($request instanceof VerifyEmailIndexRequest) {
            $authUser = $request->getAuthUser();
            $email = $authUser->getEmailAddress();
            $isLoggedIn = true;
        } elseif ($request instanceof VerifyEmailIndexForGuestRequest) {
            $email = $request->getCurrentTargetEmail();
            $isLoggedIn = false;
        } else {
            throw AppExceptions::invalidArgumentException(AppErrorCode::INVALID_ARGUMENT_GENERAL);
        }

        $session = $request->session();

        $vr->isVerificationLinkResent = $session->get(
            SellerSessions::VERIFY_EMAIL_VERIFICATION_LINK_RESENT, false);
        $vr->atVerificationLinkSent = CarbonImmutable::make($session->get(
            SellerSessions::VERIFY_EMAIL_VERIFICATION_LINK_SENT_AT, null));
        $vr->isLoggedIn = $isLoggedIn;
        $vr->canResendVerificationLink = $isLoggedIn;
        $vr->email = $email;
        $vr->hidden_email = $vr->email->getString();

        if ($vr->isVerificationLinkResent) {
            if ($vr->successMessage === null) {
                $vr->successMessage = trans('messages.verify_email.message_resent_new_link');
            }
        }

        return $vr;
    }

    public function getSentMessage() : string
    {
        return trans('messages.verify_email.message_sent.seller', [
            'email' => $this->email->getString(),
        ]);
    }

    public function getSentDateTimeMessage() : ?string
    {
        if ($this->atVerificationLinkSent === null) {
            return null;
        }

        return sprintf('%s', $this->atVerificationLinkSent->toDateTimeString());
    }

    public function getTitle(): string
    {
        return '仮登録完了';
    }
}
