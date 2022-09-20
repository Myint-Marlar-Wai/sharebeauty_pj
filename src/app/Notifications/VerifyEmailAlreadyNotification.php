<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Auth\Models\HasPrimaryKeyAuthUser;
use App\Auth\Models\VerifyEmailExecutor;
use App\Constants\App\AppSystem;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Http\Routes\SellerRoutes;
use App\Http\Routes\ShopRoutes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailAlreadyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via(mixed $notifiable): array|string
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        $loginUrl = $this->loginUrl($notifiable);

        return $this->buildMailMessage(loginUrl: $loginUrl);
    }

    /**
     * Get the verify email notification mail message for the given URL.
     *
     * @param string $loginUrl
     * @return MailMessage
     */
    protected function buildMailMessage(string $loginUrl): MailMessage
    {
        return match (app_core()->getSystem()) {
            AppSystem::Shop => $this->buildMailMessageForXXX(loginUrl: $loginUrl),
            AppSystem::Seller => $this->buildMailMessageForXXX(loginUrl: $loginUrl),
            AppSystem::Admin => throw new \BadMethodCallException('To be implemented'),
            AppSystem::Batch => throw new \BadMethodCallException('To be implemented'),
        };
    }

    protected function buildMailMessageForXXX(string $loginUrl): MailMessage
    {
        return (new MailMessage())
            ->subject('【ONCE EC】登録の申請について')
            ->greeting('いつもONCE ECをご利用いただきありがとうございます。')
            ->line('既にご利用いただける状態のため、以下のURLからログインしてください。')
            ->action('ログイン', $loginUrl)
            ->line('※本メールに心当たりがない場合、大変お手数ですがお問い合わせまでお送りください。');
    }

    protected function castNotifiable(mixed $notifiable): VerifyEmailExecutor&MustVerifyEmailContract&HasPrimaryKeyAuthUser
    {
        if (! ($notifiable instanceof MustVerifyEmailContract)) {
            throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_GENERAL);
        }
        if (! ($notifiable instanceof HasPrimaryKeyAuthUser)) {
            throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_GENERAL);
        }
        if (! ($notifiable instanceof VerifyEmailExecutor)) {
            throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_GENERAL);
        }

        return $notifiable;
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param mixed $notifiable
     * @return string
     */
    protected function loginUrl(mixed $notifiable): string
    {
        $notifiable = $this->castNotifiable($notifiable);
        return match (app_core()->getSystem()) {
            AppSystem::Shop => $this->loginUrlForShop($notifiable),
            AppSystem::Seller => $this->loginUrlForSeller($notifiable),
            AppSystem::Admin => throw new \BadMethodCallException('To be implemented'),
            AppSystem::Batch => throw new \BadMethodCallException('To be implemented'),
        };
    }

    protected function loginUrlForShop(VerifyEmailExecutor&MustVerifyEmailContract&HasPrimaryKeyAuthUser $notifiable): string
    {
        return ShopRoutes::urlLogin();
    }

    protected function loginUrlForSeller(VerifyEmailExecutor&MustVerifyEmailContract&HasPrimaryKeyAuthUser $notifiable): string
    {
        return SellerRoutes::urlLogin();
    }

}
