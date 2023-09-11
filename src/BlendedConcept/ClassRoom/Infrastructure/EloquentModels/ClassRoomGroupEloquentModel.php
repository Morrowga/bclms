<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Classroom\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomGroupEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'classroom_groups';

    protected $fillable = [
        'id',
        'classroom_Id',
        'name',
    ];

    // public function getImageAttribute()
    // {
    //     return $this->getMedia('classroom_photo');
    // }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%'.$name.'%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }
}
