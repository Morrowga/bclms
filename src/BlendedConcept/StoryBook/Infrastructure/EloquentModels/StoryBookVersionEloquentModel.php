<?php

declare(strict_types=1);

namespace Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;
use Devleaptech\LaravelH5p\Eloquents\H5pResult;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\ParentUserEloquentModel;

class StoryBookVersionEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'storybook_versions';
    protected $appends = [
        'owner'
    ];
    protected $fillable = [
        'id',
        'storybook_id',
        'teacher_id',
        'parent_id',
        'name',
        'description',
        'h5p_id'
    ];
    public function getOwnerAttribute()
    {
        return ($this->teacher ?? $this->parent) ?? null;
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

    public function storybook_assigments(): BelongsToMany
    {
        return $this->belongsToMany(StudentEloquentModel::class, 'storybook_assignments', 'storybook_version_id', 'student_id')->withPivot('completed_once');
    }

    public function storybook()
    {
        return $this->belongsTo(StoryBookEloquentModel::class, 'storybook_id')->with('devices');
    }
    public function teacher()
    {
        return $this->belongsTo(TeacherEloquentModel::class, 'teacher_id')->with('user');
    }
    public function result()
    {
        return $this->hasOne(H5pResult::class, 'content_id', 'h5p_id');
    }
    public function parent()
    {
        return $this->belongsTo(ParentUserEloquentModel::class, 'parent_id')->with('user');
    }
}
