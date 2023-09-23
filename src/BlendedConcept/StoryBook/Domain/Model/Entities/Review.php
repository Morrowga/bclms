<?php

namespace Src\BlendedConcept\StoryBook\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class Review extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $given_by_user_id,
        public readonly int $storybook_id,
        public readonly int $stars,
        public readonly string $feedback,
        public readonly ?string $given_on,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'given_by_user_id' => $this->given_by_user_id,
            'storybook_id' => $this->storybook_id,
            'stars' => $this->stars,
            'feedback' => $this->feedback,
            'given_on' => $this->given_on,
        ];
    }
}
