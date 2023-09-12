<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;

class AnnouncementToB2BEloquentModel extends Model
{
    protected $table = 'announcement_to_b2b_user';

    protected $fillable = [
        'announcement_id',
        'to_b2b_id',
        'is_cleared',
    ];

    // public function author_id()
    // {
    //     return $this->belongsTo(OrganizationEloquentModel::class, 'author_id', 'id');
    // }

    // public function target_role_id()
    // {
    //     return $this->belongsTo(UserEloquentModel::class, 'target_role_id', 'id');
    // }

    // public function scopeFilter($query, $filters)
    // {
    //     $query->when($filters['name'] ?? false, function ($query, $name) {
    //         $query->where('title', 'like', '%'.$name.'%');
    //     });
    //     $query->when($filters['search'] ?? false, function ($query, $search) {
    //         $query->where('title', 'like', '%'.$search.'%');
    //     });
    // }
}
