<?php

namespace Src\BlendedConcept\Disability\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Disability\Domain\Model\Entities\Device;

class DeviceData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $descripton,
        public readonly ?string $status

    ) {
    }

    public static function fromRequest(Request $request, $device_id = null): DeviceData
    {

        return new self(
            id: $device_id,
            name: $request->name,
            descripton: $request->description,
            status: $request->status,

        );
    }

    public static function fromEloquent(Device $disabilityType): self
    {
        return new self(
            id: $disabilityType->id,
            name: $disabilityType->name,
            descripton: $disabilityType->description,
            status: $disabilityType->status

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
