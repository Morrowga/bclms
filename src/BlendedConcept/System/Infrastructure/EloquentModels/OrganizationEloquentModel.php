<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Infrastructure\EloquentModels;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class OrganizationEloquentModel extends Model implements HasMedia
{

    // extends BaseTenant implements TenantWithDatabase
    use HasFactory, Notifiable, InteractsWithMedia;


    // for images
    protected $appends = [
        'image',
    ];

    protected $fillable = [
        'id',
        'plan_id',
        'name',
        'description',
        'type',
        'contact_person',
        'contact_email',
        'contact_number'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public array $rules = [
        'plan_id' => 'required',
        'name' => 'required| string| max:255',
        'description' => 'nullable |string',
        'type' => 'nullable',
        'contact_person' => 'required',
        'contact_email' => 'required ',
        'contact_number'
    ];

    public function getImageAttribute()
    {
        return $this->getMedia('image');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }



}
