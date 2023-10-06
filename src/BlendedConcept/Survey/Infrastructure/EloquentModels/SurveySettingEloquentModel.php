<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Survey\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;

class SurveySettingEloquentModel extends Model
{
    protected $table = 'survey_settings';

    protected $fillable = [
        'user_type',
        'survey_id',
    ];

    public function survey()
    {
        return $this->hasMany(SurveyEloquentModel::class, 'survey_id', 'id');
    }
}
