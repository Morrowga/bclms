<?php

namespace Src\BlendedConcept\StoryBook\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class PhysicalResource extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $storybook_id,
        public readonly string $file_src,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'storybook_id' => $this->storybook_id,
            'file_src' => $this->file_src,
        ];
    }
}
