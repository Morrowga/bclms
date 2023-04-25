<?php

declare(strict_types=1);

namespace Src\BlendedConcept\User\Domain\Model;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;


class Announcement extends Model
{
    protected $tables = 'permissions';

    protected $fillable = [
        'title',
        'message',
        'created_by',
        'trigger_on',
        'send_to'
    ];

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
