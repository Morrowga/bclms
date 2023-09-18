<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Survey\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'survey_id',
        'question_type',
        'question',
    ];

    public function options()
    {
        return $this->hasMany(QuestionOptionEloquentModel::class, 'question_id', 'id');
    }

    public function survey()
    {
        return $this->belongsTo(SurveyEloquentModel::class, 'survey_id', 'id');
    }
}
