<?php

namespace Src\Auth\Application\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerify extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $verificationLink;
    public $email;
    public $contact_number;

    public $view = 'emailVerification::register_email';

    public function __construct($name, $verificationLink, $email, $contact_number)
    {
        $this->name = $name;
        $this->verificationLink = $verificationLink;
        $this->email = $email;
        $this->contact_number = $contact_number;
    }

    public function build()
    {
        return $this->subject('Welcome to Tiggie Kids - Verify Your Account')
            ->markdown('register_email'); // Use a Blade view
    }
}
