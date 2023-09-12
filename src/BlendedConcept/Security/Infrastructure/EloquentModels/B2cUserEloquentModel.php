<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Security\Infrastructure\EloquentModels;

use Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class B2cUserEloquentModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'b2c_users';

    protected $fillable = [
        'b2c_user_id',
        'user_id',
        'current_subscription_id',
    ];

    public function users()
    {
        return $this->belongsTo(UserEloquentModel::class , 'user_id');
    }
}
