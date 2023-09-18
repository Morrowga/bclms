<?php

namespace Src\BlendedConcept\Disability\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Disability\Domain\Model\Entities\Theme;

class ThemeData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $descripton,

    ) {
    }

    public static function fromRequest(Request $request, $theme): ThemeData
    {

        return new self(
            id: $theme->id,
            name: $request->name,
            descripton: $request->description,

        );
    }

    public static function fromEloquent(Theme $theme): self
    {
        return new self(
            id: $theme->id,
            name: $theme->name,
            descripton: $theme->description,

        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->descripton,
        ];
    }
}
