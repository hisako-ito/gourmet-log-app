<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class OwnerVerifyEmail extends Notification
{

    use Queueable;

    protected $initialPassword;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($initialPassword)
    {
        $this->initialPassword = $initialPassword;
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
        $verificationUrl = URL::temporarySignedRoute(
            'owner.verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
                'redirect' => '/owner/login',
            ]
        );

        return (new MailMessage)
            ->subject('メールアドレスを確認してください')
            ->line('下のボタンをクリックして、メールアドレスの確認を完了してください。')
            ->action('メールアドレスを確認する', $verificationUrl)
            ->line("ログインには以下の初期パスワードを使用してください")
            ->line("【初期パスワード】{$this->initialPassword}")
            ->line('このメールに心当たりがない場合は、無視してください。');
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
