<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Survey\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;

class SurveyEloquentModel extends Model
{
    protected $table = 'surveys';

    protected $fillable = [
        'title',
        'description',
        'type',
        'user_type',
        'appear_on',
        'start_date',
        'end_date',
        'required',
        'repeat',
    ];

    public function questions()
    {
        return $this->hasMany(QuestionEloquentModel::class, 'survey_id', 'id');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {

            $query->where('title', 'like', '%' . $search . '%');
        });
        $query->when($filters['filter'] ?? false, function ($query, $filter) {
            if ($filter == 'completion_status') {
            } else if ($filter == 'user') {
            } else if ($filter == 'user_type') {
            } else {
                $query->orderBy($filter, config('sorting.orderBy'));
            }
        });
    }
}
