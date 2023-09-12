<?php

namespace Src\BlendedConcept\System\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\System\Application\DTO\AnnouncementToB2BData;

class AnnouncementToB2BData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $announcement_id,
        public readonly int $to_b2b_id,
        public readonly bool $is_cleared,

    ) {
    }

    public static function fromRequest(Request $request, $announcement_b2b_id): AnnouncementToB2BData
    {
        return new self(
            id: $announcement_b2c_id,
            announcement_id : $request->announcement_id,
            to_b2b_id: $request->to_b2b_id,
            is_cleared: $request->is_cleared,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'announcement_id' => $this->announcement_id,
            'to_b2b_id' => $this->to_b2b_id,
            'is_cleared' => $this->is_cleared,
        ];
    }
}
