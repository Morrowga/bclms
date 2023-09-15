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

}
