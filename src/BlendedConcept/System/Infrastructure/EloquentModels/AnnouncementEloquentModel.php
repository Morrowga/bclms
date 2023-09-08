<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class AnnouncementEloquentModel extends Model
{
    protected $table = 'announcements';

    protected $fillable = [
        'icon',
        'title',
        'message',
        'target_role_id',
        'author_id',
    ];

    public function author_id()
    {
        return $this->belongsTo(OrganizationEloquentModel::class, 'author_id', 'id');
    }

    public function target_role_id()
    {
        return $this->belongsTo(UserEloquentModel::class, 'target_role_id', 'id');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('title', 'like', '%'.$name.'%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('title', 'like', '%'.$search.'%');
        });
    }
}
