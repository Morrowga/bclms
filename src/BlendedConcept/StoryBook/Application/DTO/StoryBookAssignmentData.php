<?php

namespace Src\BlendedConcept\StoryBook\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Application\DTO\StoryBookAssignmentData;

class StoryBookAssignmentData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $storybook_version_id,
        public readonly int $student_id,
    ) {
    }

    public static function fromRequest(Request $request, $storybook_assignment_id): StoryBookAssignmentData
    {
        return new self(
            id : $storybook_assignment_id,
            storybook_version_id : $this->storybook_version_id,
            student_id : $this->student_id,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'storybook_version_id' => $this->storybook_version_id,
            'student_id' => $this->student_id,
        ];
    }
}
