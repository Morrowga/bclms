<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Survey\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\QuestionOptionEloquentModel;

class ResponseEloquentModel extends Model
{
    protected $table = 'responses';

    protected $fillable = [
        'user_id',
        'question_id',
        'student_id',
        'survey_id',
        'answer',
        'response_datetime',
    ];

    public function user()
    {
        return $this->belongsTo(UserEloquentModel::class, 'user_id', 'id');
    }

    public function options()
    {
        return $this->belongsToMany(QuestionOptionEloquentModel::class, 'response_options', 'response_id', 'option_id');
    }

    public function question()
    {
        return $this->belongsTo(QuestionEloquentModel::class, 'question_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(StudentEloquentModel::class, 'student_id', 'id');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('answer', 'like', '%'.$name.'%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('answer', 'like', '%'.$search.'%');
        });
        $query->when($filters['filter'] ?? false, function ($query, $filter) {

            if ($filter == 'completion_status') {
            } elseif ($filter == 'user') {
                $query->join('users', 'responses.user_id', 'users.id')->orderBy('users.name', config('sorting.orderBy'));
            } elseif ($filter == 'user_type') {
            } else {
                $query->orderBy($filter, config('sorting.orderBy'));
            }
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->response_datetime = now(); // Set response_datetime to the current datetime
        });
    }
}
