<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Security\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;

class ParentEloquentModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'parents';

    protected $primaryKey = 'parent_id';

    protected $fillable = [
        'parent_id',
        'user_id',
        'organisation_id',
        'curr_subscription_id',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(UserEloquentModel::class, 'user_id');
    }
}
