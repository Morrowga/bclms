<?php

declare(strict_types=1);

namespace Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\GameEloquentModel;

class GameAssignmentEloquentModel extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'game_assignments';

    protected $fillable = [
        'id',
        'game_id',
        'student_id',
        'score',
        'accuracy',
        'duration'
    ];

    public function game()
    {
        return $this->belongsTo(GameEloquentModel::class);
    }
}
