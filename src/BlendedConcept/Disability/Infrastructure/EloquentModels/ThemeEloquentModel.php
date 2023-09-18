<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Disability\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;

class ThemeEloquentModel extends Model
{
    protected $table = 'themes';

    protected $fillable = [
        'name',
        'description',

    ];

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }
}
