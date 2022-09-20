<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SendMailContactToUser extends Notification
{
    use Queueable;

    private $user;
    private $contactCategory;
    private $content;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->user = $params['user'];
        $this->contactCategory = $params['contact_category'];
        $this->content = $params['content'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('[ONCE EC] お問い合わせを受け付けました')
            ->line('ONCE ECをご利用いただきありがとうございます。')
            ->line('お問い合わせを受け付けました。')
            ->line('折り返し弊社担当より連絡させていただきます。')
            ->line('')
            ->line('問い合わせ種類：')
            ->line('　' . $this->contactCategory)
            ->line('')
            ->line('問い合わせ内容：')
            ->line('')
            ->line(new HtmlString(nl2br($this->content)));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
