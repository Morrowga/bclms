<?php

namespace Src\BlendedConcept\StoryBook\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class StoryBookVersion extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $storybook_id,
        public readonly ?int $teacher_id,
        public readonly string $name,
        public readonly string $description,
        public readonly ?int $h5p_id,
        public readonly ?string $param
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'storybook_id' => $this->storybook_id,
            'teacher_id' => $this->teacher_id,
            'name' => $this->name,
            'description' => $this->description,
            'h5p_id' => $this->h5p_id,
            'param' => $this->param
        ];
    }
}
