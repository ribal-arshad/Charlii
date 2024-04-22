<?php


namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;

    public function __construct(Model $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return \App\Mail\UserResetPasswordMail
     */
    public function build()
    {
        return $this->view('mail.user-reset-password');

    }

}
