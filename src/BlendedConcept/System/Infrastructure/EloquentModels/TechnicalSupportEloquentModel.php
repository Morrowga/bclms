<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class TechnicalSupportEloquentModel extends Model
{
    protected $table = 'support_tickets';

    protected $fillable = [
        'user_id',
        'date',
        'has_responded',
        'question',
        'response',
    ];

    public function scopeFilter($query, $filters)
    {

        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('question', 'like', '%' . $search . '%');
        });
        $query->when($filters['filter'] ?? false, function ($query, $filter) {
            if ($filter == 'status') {
            } elseif ($filter == 'name') {
                $query->join('users', 'support_tickets.user_id', 'users.id')->orderBy('users.first_name', config('sorting.orderBy'));
            } else {
                $query->orderBy($filter, config('sorting.orderBy'));
            }
        });
    }

    public function user()
    {
        return $this->hasOne(UserEloquentModel::class, 'id', 'user_id');
    }
}
