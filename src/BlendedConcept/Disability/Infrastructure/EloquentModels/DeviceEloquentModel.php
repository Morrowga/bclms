<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Disability\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;

class DeviceEloquentModel extends Model
{
    protected $table = 'devices';

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
        $query->when($filters['status'] ?? false, function ($query, $status) {
            $query->where('status', $status);
        });
        $query->when($filters['filter'] ?? false, function ($query, $filter) {
            if ($filter == 'disability') {
            } else {
                $query->orderBy($filter, config('sorting.orderBy'));
            }
        });
    }

    public function disabilityTypes()
    {
        return $this->belongsToMany(DisabilityTypeEloquentModel::class, 'disability_type_devices', 'device_id', 'disability_type_id');
    }

    public function books()
    {
        return $this->belongsToMany(StoryBookEloquentModel::class, 'storybook_devices', 'device_id', 'storybook_id');
    }
}
