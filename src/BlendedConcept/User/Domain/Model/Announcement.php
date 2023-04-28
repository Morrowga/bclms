<?php

declare(strict_types=1);

namespace Src\BlendedConcept\User\Domain\Model;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Src\BlendedConcept\Organization\Domain\Model\Organization;

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

    public function created_by()
    {
        return $this->belongsTo(Organization::class, 'created_by', 'id');
    }

    public function send_to()
    {
        return $this->belongsTo(User::class, 'send_to', 'id');
    }

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
