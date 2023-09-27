<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;

class AnnouncementToB2CEloquentModel extends Model
{
    protected $table = 'announcement_to_b2c';

    protected $fillable = [
        'announcement_id',
        'to_b2c_id',
        'is_cleared',
    ];

    // public function author_id()
    // {
    //     return $this->belongsTo(OrganisationEloquentModel::class, 'author_id', 'id');
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
