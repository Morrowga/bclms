<?php
namespace Src\BlendedConcept\Organisation\Domain\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ParentExpirationNotice extends Mailable
{
    use Queueable, SerializesModels;

    public $parent;
    public $title;
    public $description;

    public function __construct($parent, $title, $description)
    {
        $this->parent = $parent;
        $this->title = $title;
        $this->description = $description;
    }

    public function build()
    {
        return $this->view('parent_expiration_email')
            ->subject($this->title)
            ->with([
                'title' => $this->title,
                'description' => $this->description,
                'parent' => $this->parent,
        ]);
    }
}


