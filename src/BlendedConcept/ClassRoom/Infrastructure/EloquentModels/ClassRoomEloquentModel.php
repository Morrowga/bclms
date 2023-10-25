<?php

declare(strict_types=1);

namespace Src\BlendedConcept\ClassRoom\Infrastructure\EloquentModels;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;
use Src\BlendedConcept\ClassRoom\Infrastructure\EloquentModels\ClassRoomGroupEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;

class ClassRoomEloquentModel extends Model implements HasMedia
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
            $query->where('name', 'like', '%' . $name . '%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function teachers()
    {
        return $this->belongsToMany(TeacherEloquentModel::class, 'classroom_teachers', 'classroom_id', 'teacher_id')->with('user');
    }


    public function organisation()
    {
        return $this->belongsTo(OrganisationEloquentModel::class, 'organisation_id', 'id');
    }

    public function students()
    {
        return $this->belongsToMany(StudentEloquentModel::class, 'classroom_students', 'classroom_id', 'student_id')->with('user', 'groups', 'parent');
    }

    public function groups()
    {
        return $this->hasMany(ClassRoomGroupEloquentModel::class, 'classroom_id')->with('students');
    }
}
