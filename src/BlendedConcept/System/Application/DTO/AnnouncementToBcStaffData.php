<?php

namespace Src\BlendedConcept\System\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\System\Application\DTO\AnnouncementToBcStaffData;

class AnnouncementToBcStaffData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $announcement_id,
        public readonly int $to_bc_staff_user_id,
        public readonly bool $is_cleared,

    ) {
    }

    public static function fromRequest(Request $request, $announcement_bcstaff_id): AnnouncementToBcStaffData
    {
        return new self(
            id: $announcement_bcstaff_id,
            announcement_id : $request->announcement_id,
            to_bc_staff_user_id: $request->to_bc_staff_user_id,
            is_cleared: $request->is_cleared,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'announcement_id' => $this->announcement_id,
            'to_bc_staff_user_id' => $this->to_bc_staff_user_id,
            'is_cleared' => $this->is_cleared,
        ];
    }
}
