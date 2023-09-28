<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Disability\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningNeedEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'learning_needs';

    protected $fillable = [
        'name',
        'description',
    ];

    public function sub_learnings()
    {
        return $this->hasMany(SubLearningTypeEloquentModel::class, 'learning_needs_id', 'id');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
}
