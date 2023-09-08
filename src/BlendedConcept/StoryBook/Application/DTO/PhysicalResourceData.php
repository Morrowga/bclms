<?php

namespace Src\BlendedConcept\StoryBook\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Application\DTO\PhysicalResourceData;

class PhysicalResourceData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $storybook_id,
        public readonly string $file_src,
    ) {
    }


    public static function fromRequest(Request $request, $physical_resource_id): PhysicalResourceData
    {
        return new self(
            id : $physical_resource_id,
            storybook_id : $this->storybook_id,
            file_src : $this->file_src,
        );
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
