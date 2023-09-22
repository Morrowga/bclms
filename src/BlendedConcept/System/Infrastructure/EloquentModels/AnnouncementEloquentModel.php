<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;

class AnnouncementEloquentModel extends Model
{
    protected $table = 'announcements';

    protected $fillable = [
        'icon',
        'title',
        'message',
        'by',
        'to',
    ];

    public function announcement_to_b2c_user()
    {
        return $this->hasMany(AnnouncementToB2BEloquentModel::class, 'announcement_id', 'id');
    }

    public function announcement_to_b2b_user()
    {
        return $this->hasMany(AnnouncementToB2CEloquentModel::class, 'announcement_id', 'id');
    }

    public function announcement_to_bcstaff_user()
    {
        return $this->hasMany(AnnouncementToBcStaffEloquentModel::class, 'announcement_id', 'id');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('title', 'like', '%'.$search.'%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('message', 'like', '%'.$search.'%');
        });
    }
}
