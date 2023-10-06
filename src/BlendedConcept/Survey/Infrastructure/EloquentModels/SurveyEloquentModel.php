<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Survey\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\SurveySettingEloquentModel;

class SurveyEloquentModel extends Model
{
    protected $table = 'surveys';

    protected $fillable = [
        'title',
        'description',
        'type',
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

    public function survey_settings()
    {
        return $this->hasMany(SurveySettingEloquentModel::class, 'survey_id', 'id');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {

            $query->where('title', 'like', '%'.$search.'%');
        });
        $query->when($filters['filter'] ?? false, function ($query, $filter) {
            if ($filter == 'completion_status') {
            } elseif ($filter == 'user') {
            } elseif ($filter == 'user_type') {
            } else {
                $query->orderBy($filter, config('sorting.orderBy'));
            }
        });
    }
}
