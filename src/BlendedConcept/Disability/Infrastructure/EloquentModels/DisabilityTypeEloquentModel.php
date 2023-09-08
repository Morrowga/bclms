<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Disability\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;


class DisabilityTypeEloquentModel extends Model
{
    protected $table = 'disability_types';

    protected $fillable = [
        'name',
        'description',

    ];

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
    }
}
