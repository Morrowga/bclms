<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Organization\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class OrganizationEloquentModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Notifiable;

    protected $table = 'organizations';

    // for images
    protected $appends = [
        'image',
    ];

    protected $fillable = [
        'curr_subscription_id',
        'org_admin_id',
        'name',
        'contact_name',
        'contact_email',
        'contact_number',
        'sub_domain',
        'logo',
        'status',
    ];

    public function getImageAttribute()
    {
        return $this->getMedia('image');
    }

    public function subscription()
    {
        return $this->belongsTo(SubscriptionEloquentModel::class, 'curr_subscription_id', 'id');
    }

    public function org_admin()
    {
        return $this->belongsTo(UserEloquentModel::class, 'org_admin_id', 'id');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%'.$name.'%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }
}
