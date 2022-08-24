<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class APIPasswordResetNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code, $domain)
    {
        $this->reset_code = $code;
        $this->domain = $domain;
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
                ->mailer($this->domain)
                ->greeting('Hello!')
                ->line('A password reset for the account associated with this email has been requested.')
                ->line('Please enter the code below in your password reset page')
                ->line(new HtmlString('<strong style="text-align: center">' . $this->reset_code . '</strong>'))
                ->line('If you did not request a password reset, please ignore this message. ')
                // ->action('Notification Action', url('/'))
                // ->line('Thank you for using our application!');
                ->subject('Password reset request');
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
