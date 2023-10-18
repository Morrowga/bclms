<?php
namespace Src\BlendedConcept\Organisation\Domain\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganisationExpirationNotice extends Mailable
{
    use Queueable, SerializesModels;

    public $organisation;
    public $title;
    public $description;

    public function __construct($organisation, $title, $description)
    {
        $this->organisation = $organisation;
        $this->title = $title;
        $this->description = $description;
    }

    public function build()
    {
        return $this->view('expiration_email')
            ->subject($this->title)
            ->with([
                'title' => $this->title,
                'description' => $this->description,
                'organisation' => $this->organisation,
        ]);
    }
}


