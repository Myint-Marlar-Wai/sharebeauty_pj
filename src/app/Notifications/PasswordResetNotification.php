<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Auth\SellerAuth;
use App\Auth\ShopAuth;
use App\Constants\App\AppSystem;
use App\Data\Common\EmailAddress;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Http\Routes\SellerRoutes;
use App\Http\Routes\ShopRoutes;
use Carbon\CarbonImmutable;
use Config;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Log;

class PasswordResetNotification extends ResetPasswordNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $resetUrl = $this->resetUrl($notifiable);
        Log::debug('password-reset-notification', ['resetUrl' => $resetUrl]);

        return $this->buildMailMessage($resetUrl);
    }

    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param  string  $url
     * @return MailMessage
     */
    protected function buildMailMessage($url): MailMessage
    {
        return match (app_core()->getSystem()) {
            AppSystem::Shop => $this->buildMailMessageForXXX($url),
            AppSystem::Seller => $this->buildMailMessageForXXX($url),
            AppSystem::Admin => throw new \BadMethodCallException('To be implemented'),
            AppSystem::Batch => throw new \BadMethodCallException('To be implemented'),
        };
    }

    protected function buildMailMessageForXXX($url): MailMessage
    {
        return (new MailMessage)
            ->subject('【ONCE EC】パスワードリセットのお知らせ')
            ->greeting('いつもONCE ECをご利用いただきありがとうございます。')
            ->line('申請いただいたIDのパスワードリセットを開始いたします。')
            ->line('以下のURLへアクセスしパスワードの再設定をお願いします。')
            ->action('パスワードリセット', $url)
            ->line('※本メールに心当たりがない場合、大変お手数ですがお問い合わせまでお送りください。。');
    }

    /**
     * Get the reset URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function resetUrl($notifiable): string
    {
        if (! ($notifiable instanceof CanResetPasswordContract)) {
            throw AppExceptions::logicException(AppErrorCode::LOGIC_EXCEPTION_GENERAL);
        }

        return match (app_core()->getSystem()) {
            AppSystem::Shop =>  $this->resetUrlForShop($notifiable),
            AppSystem::Seller => $this->resetUrlForSeller($notifiable),
            AppSystem::Admin => throw new \BadMethodCallException('To be implemented'),
            AppSystem::Batch => throw new \BadMethodCallException('To be implemented'),
        };
    }

    protected function getPasswordConfig(string $name) : array
    {
        return Config::get("auth.passwords.{$name}");
    }

    protected function getExpiration(string $name) : CarbonImmutable
    {
        $config = $this->getPasswordConfig($name);
        $expireMinInt = $config['expire'];
        assert(is_int($expireMinInt));
        Log::debug('password-reset-expire', ['minutes' => $expireMinInt]);

        return CarbonImmutable::now()->addMinutes($expireMinInt);
    }

    protected function resetUrlForShop(CanResetPasswordContract $notifiable): string
    {
        $email = EmailAddress::from($notifiable->getEmailForPasswordReset());

        return ShopRoutes::singedUrlPasswordResetLink(
            token: $this->token,
            email: $email,
            expiration: $this->getExpiration(ShopAuth::PASSWORD)
        );
    }

    protected function resetUrlForSeller(CanResetPasswordContract $notifiable): string
    {
        $email = EmailAddress::from($notifiable->getEmailForPasswordReset());

        return SellerRoutes::singedUrlPasswordResetLink(
            token: $this->token,
            email: $email,
            expiration: $this->getExpiration(SellerAuth::PASSWORD)
        );
    }
}
