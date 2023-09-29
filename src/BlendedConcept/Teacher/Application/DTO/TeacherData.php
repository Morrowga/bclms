<?php

namespace Src\BlendedConcept\Teacher\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Teacher\Domain\Model\Teacher;

class TeacherData
{
    public function __construct(
        public readonly ?int $teacher_id,
        public readonly int $user_id,
        public readonly ?int $organisation_id,
        public readonly ?float $allocated_storage_limit,
        public readonly ?int $curr_subscription_id
    ) {
    }

    public static function fromRequest(Request $request, $teacher_id = null): TeacherData
    {

        return new self(
            teacher_id: $teacher_id,
            user_id: $request->user_id,
            organisation_id: $request->organisation_id,
            allocated_storage_limit: $request->allocated_storage_limit,
            curr_subscription_id: $request->curr_subscription_id
        );
    }

    public static function fromEloquent(Teacher $teacher): self
    {
        return new self(
            teacher_id: $teacher->teacher_id,
            user_id: $teacher->user_id,
            organisation_id: $teacher->organisation_id,
            allocated_storage_limit: $teacher->allocated_storage_limit,
            curr_subscription_id: $teacher->curr_subscription_id
        );
    }

    public function toArray(): array
    {
        return [
            "teacher_id" => $this->teacher_id,
            "user_id"  => $this->user_id,
            "organisation_id" => $this->organisation_id,
            "allocated_storage_limit" => $this->allocated_storage_limit,
            "curr_subscription_id" => $this->curr_subscription_id
        ];
    }
}
