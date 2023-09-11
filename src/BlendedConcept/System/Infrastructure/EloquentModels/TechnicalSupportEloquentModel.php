<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;

class TechnicalSupportEloquentModel extends Model
{
    protected $table = 'support_tickets';

    protected $fillable = [
        'user_id',
        'date',
        'has_responsed',
        'question',
        'response',
    ];
}
