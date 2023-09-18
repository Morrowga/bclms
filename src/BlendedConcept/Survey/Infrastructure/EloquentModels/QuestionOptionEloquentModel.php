<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Survey\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOptionEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'question_options';

    protected $fillable = [
        'question_id',
        'content',
    ];
}
