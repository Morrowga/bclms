<?php

namespace Src\BlendedConcept\StoryBook\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class SubLearningNeed extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $storybook_version_id,
        public readonly int $student_id,
    ) {
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
