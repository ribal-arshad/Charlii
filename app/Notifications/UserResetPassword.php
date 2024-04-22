<?php

namespace App\Notifications;

use App\Mail\UserResetPasswordMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserResetPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notiftion instance.
     *
     * @return voidica
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's elive
     * @param  mixed  $notifiablry channels.
     *de
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
        return (new UserResetPasswordMail($notifiable))->to($notifiable->email);
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
