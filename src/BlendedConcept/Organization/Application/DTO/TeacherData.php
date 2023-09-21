<?php

namespace Src\BlendedConcept\Organization\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Organization\Application\DTO\TeacherData;
use Src\BlendedConcept\Organization\Domain\Model\Entities\Teacher;

class TeacherData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly ?string $contact_number,
        public readonly ?string $email_verification_send_on,
    ) {
    }

    public static function fromRequest(Request $request, $user_id = null): TeacherData
    {

        return new self(
            id: $user_id,
            first_name: $request->first_name,
            last_name: $request->last_name,
            email: $request->email,
            email_verification_send_on: $request->email_verification_send_on,
            contact_number: $request->contact_number,
        );
    }

    public static function fromEloquent(Teacher $teacher): self
    {
        return new self(
            id: $teacher->id,
            first_name: $teacher->first_name,
            last_name: $teacher->last_name,
            email: $teacher->email,
            email_verification_send_on: $teacher->email_verification_send_on,
            contact_number: $teacher->contact_number,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'email_verification_send_on' => $this->email_verification_send_on,
            'contact_number' => $this->contact_number,
        ];
    }
}
