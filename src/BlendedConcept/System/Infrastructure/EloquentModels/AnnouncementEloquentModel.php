<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

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

    public function users()
    {
        return $this->belongsToMany(UserEloquentModel::class, 'users_announcements', 'announcement_id', 'user_id')
            ->withPivot('is_cleared'); // Include the additional pivot column 'is_cleared'
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
