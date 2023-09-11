<?php

declare(strict_types=1);

namespace Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PhysicalResourceEloquentModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Notifiable;

    protected $table = 'physical_resources';

    // for images
    protected $appends = [
        'file_src',
    ];

    protected $fillable = [
        'id',
        'storybook_id',
        'file_src',
    ];

    public function getImageAttribute()
    {
        return $this->getMedia('file_src');
    }

    // public function scopeFilter($query, $filters)
    // {
    //     $query->when($filters['name'] ?? false, function ($query, $name) {
    //         $query->where('name', 'like', '%' . $name . '%');
    //     });
    //     $query->when($filters['search'] ?? false, function ($query, $search) {
    //         $query->where('name', 'like', '%' . $search . '%');
    //     });
    // }
}
