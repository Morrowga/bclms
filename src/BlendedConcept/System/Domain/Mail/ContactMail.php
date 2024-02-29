<?php

namespace Src\BlendedConcept\System\Domain\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $contact_message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $contact_message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->contact_message = $contact_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = $this->name;
        $email = $this->email;
        $contact_message = $this->contact_message;

        return $this->from($email, 'BC LMS')
        ->subject('New Contact Form Submission')
        ->view('emails.contactEmail',compact('name', 'email', 'contact_message'));
    }
}
