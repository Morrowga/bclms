<?php

namespace Src\BlendedConcept\Disability\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Disability\Domain\Model\DisabilityType;

class DisabilityTypeData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $descripton,

    ) {
    }

    public static function fromRequest(Request $request, $disability_type_id = null): DisabilityTypeData
    {

        return new self(
            id: $disability_type_id,
            name: $request->name,
            descripton: $request->description,

        );
    }

    public static function fromEloquent(DisabilityType $disabilityType): self
    {
        return new self(
            id: $disabilityType->id,
            name: $disabilityType->name,
            descripton: $disabilityType->description,

        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->descripton
        ];
    }
}
