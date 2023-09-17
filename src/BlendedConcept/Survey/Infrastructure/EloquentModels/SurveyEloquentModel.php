<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Survey\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\Survey\Infrastructure\EloquentModels\QuestionEloquentModel;

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
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('title', 'like', '%' . $name . '%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%');
        });
    }
}
