<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Organization\Infrastructure\EloquentModels;


use Spatie\MediaLibrary\HasMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OrganizationEloquentModel extends Model implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;

    protected $table = 'organizations';
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
        return $this->belongsTo(PlanEloquentModel::class,'plan_id','id');
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