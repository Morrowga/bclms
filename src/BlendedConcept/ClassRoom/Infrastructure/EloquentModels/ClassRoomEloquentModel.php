<?php

declare(strict_types=1);

namespace Src\BlendedConcept\ClassRoom\Infrastructure\EloquentModels;


use Illuminate\Database\Eloquent\Model;

class ClassRoomEloquentModel extends Model
{
    protected $table = 'classrooms';


    protected $fillable = [
        'organization_id',
        'teacher_id',
        'name',
        'venue'
    ];


    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->orWhere('name', 'like', '%' . $search . '%');
        });
    }
}
