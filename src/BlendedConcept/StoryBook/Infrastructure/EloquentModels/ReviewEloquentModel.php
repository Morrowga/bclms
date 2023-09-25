<?php

declare(strict_types=1);

namespace Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\B2bUserEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class ReviewEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'id',
        'given_by_user_id',
        'storybook_id',
        'stars',
        'feedbacks',
        'given_on',
    ];

    public function storybooks()
    {
        return $this->hasOne(StoryBookEloquentModel::class, 'id', 'storybook_id');
    }

    public function users()
    {
        return $this->hasMany(UserEloquentModel::class, 'id', 'given_by_user_id');
    }
    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
        $query->when($filters['filter'] ?? false, function ($query, $filter) {
            if ($filter == 'book') {
            } else {
                $query->orderBy($filter, config('sorting.orderBy'));
            }
        });
    }
}
