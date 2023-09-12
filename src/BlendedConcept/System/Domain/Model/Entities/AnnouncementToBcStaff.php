<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Domain\Model\Entities;

use Src\Common\Domain\Entity;

class AnnouncementToBcStaff extends Entity
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $announcement_id,
        public readonly int $to_bc_staff_user_id,
        public readonly bool $is_cleared,
    ) {
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
