<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Classroom\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;

class ClassroomEloquentModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Notifiable;

    protected $table = 'classrooms';

    // for images
    // protected $appends = [
    //     'classroom_photo',
    // ];

    protected $fillable = [
        'id',
        'organisation_id',
        'name',
        'description',
        'classroom_photo',
    ];

    public function getImageAttribute()
    {
        return $this->getMedia('classroom_photo');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%'.$name.'%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }

    public function teachers()
    {
        return $this->belongsToMany(UserEloquentModel::class, 'classroom_teachers', 'classroom_id', 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(StudentEloquentModel::class, 'classroom_students', 'classroom_id', 'student_id')->with('user', 'groups');
    }

    public function groups()
    {
        return $this->hasMany(ClassroomGroupEloquentModel::class, 'classroom_id')->with('students');
    }
}
