<?php

declare(strict_types=1);

namespace Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DeviceEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\DisabilityTypeEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\SubLearningTypeEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\ThemeEloquentModel;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\PlaylistEloquentModel;
use Devleaptech\LaravelH5p\Eloquents\H5pResult;

class StoryBookEloquentModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Notifiable;

    protected $table = 'storybooks';

    // for images
    protected $appends = [
        'thumbnail_img',
        'physical_resources'
    ];

    protected $fillable = [
        'id',
        'name',
        'description',
        'thumbnail_img',
        'num_gold_coins',
        'num_silver_coins',
        'is_free',
        'h5p_id'
    ];

    public function getThumbnailImgAttribute()
    {
        return $this->getFirstMedia('thumbnail_img')->original_url ?? '';
    }

    public function getPhysicalResourcesAttribute()
    {
        $media = $this->getMedia('physical_resource_src');

        return $media->map(function ($psy) {
            return [
                "id" => $psy->id,
                "name" => $psy->name ?? '',
                "file_name" => $psy->file_name ?? '',
                "type" => $psy->mime_type,
                "size" => $psy->size,
                "url" => $psy->original_url ?? ''
            ];
        });
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
        $query->when($filters['filter'] ?? false, function ($query, $filter) {
            if ($filter == 'role') {
            } elseif ($filter == 'asc') {
                $query->orderBy('name', 'asc');
            } elseif ($filter == 'desc') {
                $query->orderBy('name', 'desc');
            } else {
                $query->orderBy($filter, config('sorting.orderBy'));
            }
        });
    }

    public function learningneeds(): BelongsToMany
    {
        return $this->belongsToMany(SubLearningTypeEloquentModel::class, 'storybook_learning_needs', 'storybook_id', 'sub_learning_type_id');
    }

    public function themes(): BelongsToMany
    {
        return $this->belongsToMany(ThemeEloquentModel::class, 'storybook_themes', 'storybook_id', 'theme_id');
    }

    public function disability_types(): BelongsToMany
    {
        return $this->belongsToMany(DisabilityTypeEloquentModel::class, 'storybook_disability_types', 'storybook_id', 'disability_type_id');
    }

    public function devices(): BelongsToMany
    {
        return $this->belongsToMany(DeviceEloquentModel::class, 'storybook_devices', 'storybook_id', 'device_id');
    }

    public function physical_resources(): HasOne
    {
        return $this->hasOne(PhysicalResourceEloquentModel::class, 'storybook_id', 'id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(TagEloquentModel::class, 'storybook_tags', 'storybook_id', 'tag_id');
    }

    public function storybook_versions(): HasMany
    {
        return $this->hasMany(StoryBookVersionEloquentModel::class, 'storybook_id', 'id');
    }

    public function associateTags(array $tagNames)
    {
        foreach ($tagNames as $tagName) {
            $tag = TagEloquentModel::firstOrCreate(['name' => $tagName]);

            // Attach the tag to the game
            $this->tags()->attach($tag->id);
        }
    }

    public function book_versions()
    {
        return $this->hasMany(StoryBookVersionEloquentModel::class, 'storybook_id')->with('teacher', 'result');
    }

    public function playlists()
    {
        return $this->hasMany(PlaylistEloquentModel::class, 'student_id');
    }

    public function result()
    {
        return $this->hasOne(H5pResult::class, 'content_id', 'h5p_id');
    }

    public function pathways()
    {
        return $this->belongsToMany(PathwayEloquentModel::class, 'pathway_storybook', 'storybook_id', 'pathway_id')->withPivot('sequence');
    }
}
