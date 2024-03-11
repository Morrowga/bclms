<?php

declare(strict_types=1);

namespace Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;

class StoryBookAssignmentEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'storybook_assignments';

    protected $fillable = [
        'id',
        'storybook_version_id',
        'student_id',
        'curr_timestamp',
        'completed_once',
        'score',
        'accuracy',
        'duration'
    ];

    // public function scopeFilter($query, $filters)
    // {
    //     $query->when($filters['name'] ?? false, function ($query, $name) {
    //         $query->where('name', 'like', '%' . $name . '%');
    //     });
    //     $query->when($filters['search'] ?? false, function ($query, $search) {
    //         $query->where('name', 'like', '%' . $search . '%');
    //     });
    // }

    public function book_version()
    {
        return $this->belongsTo(StoryBookVersionEloquentModel::class, 'storybook_version_id');
    }

    public function student()
    {
        return $this->belongsTo(StudentEloquentModel::class, 'student_id');
    }
}
