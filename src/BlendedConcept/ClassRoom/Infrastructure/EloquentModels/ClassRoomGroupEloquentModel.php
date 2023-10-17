<?php

declare(strict_types=1);

namespace Src\BlendedConcept\ClassRoom\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;

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
            $query->where('name', 'like', '%' . $name . '%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function students()
    {
        return $this->belongsToMany(StudentEloquentModel::class, 'group_students', 'classroom_group_id', 'student_id')->with('user', 'parent');
    }
}
