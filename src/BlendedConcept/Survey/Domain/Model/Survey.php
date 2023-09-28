<?php

namespace Src\BlendedConcept\Survey\Domain\Model;

use Src\Common\Domain\AggregateRoot;

class Survey extends AggregateRoot
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $type,
        public readonly string $user_type,
        public readonly string $appear_on,
        public readonly string $start_date,
        public readonly string $end_date,
        public readonly bool $required,
        public readonly bool $repeat,
        public readonly string $questions,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'user_type' => $this->user_type,
            'appear_on' => $this->appear_on,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'required' => $this->required,
            'repeat' => $this->repeat,
            'questions' => $this->questions,
        ];
    }
}
