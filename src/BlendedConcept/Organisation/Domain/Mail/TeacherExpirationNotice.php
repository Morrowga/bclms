<?php
namespace Src\BlendedConcept\Organisation\Domain\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeacherExpirationNotice extends Mailable
{
    use Queueable, SerializesModels;

    public $teacher;
    public $title;
    public $description;

    public function __construct($teacher, $title, $description)
    {
        $this->teacher = $teacher;
        $this->title = $title;
        $this->description = $description;
    }

    public function build()
    {
        return $this->view('teacher_expiration_email')
            ->subject($this->title)
            ->with([
                'title' => $this->title,
                'description' => $this->description,
                'teacher' => $this->teacher,
        ]);
    }
}


