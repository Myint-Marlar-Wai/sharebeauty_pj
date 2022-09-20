<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Auth\Models\HasPrimaryKeyAuthUser;
use App\Auth\Models\VerifyEmailExecutor;
use App\Constants\App\AppSystem;
use App\Data\Auth\VerifyEmailData;
use App\Exceptions\AppErrorCode;
use App\Exceptions\AppExceptions;
use App\Http\Routes\SellerRoutes;
use App\Http\Routes\ShopRoutes;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail implements ShouldQueue
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
        $verificationUrl = $this->verificationUrl($notifiable);
        \Log::debug('verify-email-notification', ['verificationUrl' => $verificationUrl]);

        return $this->buildMailMessage($verificationUrl);
    }

    /**
     * Get the verify email notification mail message for the given URL.
     *
     * @param string $url
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

    protected function buildMailMessageForXXX(string $url): MailMessage
    {
        return (new MailMessage())
            ->subject('【ONCE EC】仮登録完了のお知らせ')
            ->greeting('ONCE ECのご登録ありがとうございます。')
            ->line('以下のURLへアクセスすることで登録が完了いたします。')
            ->action('メールアドレスを確認', $url)
            ->line('※上記URLは24時間のみ有効です。')
            ->line('')
            ->line('-- ONCE ECでできること --')
            ->line('公開したショップをお客様に案内いただくだけで、お客様が欲しい時にいつでも商品を提供することができるようになります。')
            ->line('お客様の「欲しい」に応え、お客様の満足度向上にご利用ください。')
            ->line('')
            ->line('[ショップを始める]')
            ->line('1．ログインしショップ一覧画面を開く')
            ->line('2．ショップ作成へ進みショップ情報を登録')
            ->line('3．商品一覧へ進み販売商品を登録')
            ->line('4．ショップを公開')
            ->line('')
            ->line('[ショップを共有する]')
            ->line('1．ショップ画面からURL共有かQRコードを選択')
            ->line('2．施術時のお客様に共有')
            ->line('')
            ->line('[売上を確認する]')
            ->line('1．ログインし売上管理画面を開く');
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
    protected function verificationUrl($notifiable): string
    {
        $notifiable = $this->castNotifiable($notifiable);
        $data = $notifiable->generateVerifyEmailData();

        return match (app_core()->getSystem()) {
            AppSystem::Shop => $this->verificationUrlForShop($data),
            AppSystem::Seller => $this->verificationUrlForSeller($data),
            AppSystem::Admin => throw new \BadMethodCallException('To be implemented'),
            AppSystem::Batch => throw new \BadMethodCallException('To be implemented'),
        };
    }

    protected function verificationUrlForShop(VerifyEmailData $verifyEmailData): string
    {
        return ShopRoutes::signedUrlVerificationVerifyLink(
            token: $verifyEmailData->token,
            email: $verifyEmailData->email,
            expiration: $verifyEmailData->expiration
        );
    }

    protected function verificationUrlForSeller(VerifyEmailData $verifyEmailData): string
    {
        return SellerRoutes::signedUrlVerificationVerifyLink(
            token: $verifyEmailData->token,
            email: $verifyEmailData->email,
            expiration: $verifyEmailData->expiration
        );
    }
}
