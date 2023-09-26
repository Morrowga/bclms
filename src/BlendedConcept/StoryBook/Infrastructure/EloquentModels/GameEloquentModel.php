<?php

declare(strict_types=1);

namespace Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DeviceEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;

class GameEloquentModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Notifiable;

    protected $table = 'games';

    // for images
    protected $appends = [
        'thumbnail',
        'game_file',
    ];

    protected $fillable = [
        'id',
        'name',
        'description',
        'game_file',
        'thumbnail',
        'num_gold_coins',
        'num_silver_coins',
    ];

    public function getThumbnailAttribute()
    {
        // Check if there is any media associated with the 'thumbnail' collection
        $media = $this->getMedia('thumbnail');

        // If there is media, return the URL of the first item
        if ($media->isNotEmpty()) {
            return $media[0]->getUrl();
        }

        // Return a default thumbnail URL or null if there's no media
        return null;
    }

    public function getGameFileAttribute()
    {
        // Check if there is any media associated with the 'thumbnail' collection
        $media = $this->getMedia('game_file');

        // If there is media, return the URL of the first item
        if ($media->isNotEmpty()) {
            return $media[0]->getUrl();
        }

        // Return a default thumbnail URL or null if there's no media
        return null;
    }

    public function tags()
    {
        return $this->belongsToMany(TagEloquentModel::class, 'games_tags', 'game_id', 'tag_id');
    }

    public function disabilityTypes()
    {
        return $this->belongsToMany(DisabilityTypeEloquentModel::class, 'game_disability_types', 'game_id', 'disability_type_id');
    }

    public function devices()
    {
        return $this->belongsToMany(DeviceEloquentModel::class, 'game_devices', 'game_id', 'device_id');
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

    public function associateTags(array $tagNames)
    {
        foreach ($tagNames as $tagName) {
            $tag = TagEloquentModel::firstOrCreate(['name' => $tagName]);

            // Attach the tag to the game
            $this->tags()->attach($tag->id);
        }
    }
}
