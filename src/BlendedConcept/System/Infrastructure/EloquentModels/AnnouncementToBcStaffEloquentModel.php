<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;

class AnnouncementToBcStaffEloquentModel extends Model
{
    protected $table = 'announcement_to_bc_staff';

    protected $fillable = [
        'announcement_id',
        'to_bc_staff_user_id',
        'is_cleared',
    ];
}
