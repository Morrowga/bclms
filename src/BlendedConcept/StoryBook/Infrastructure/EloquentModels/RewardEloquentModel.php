<?php

declare(strict_types=1);

namespace Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;

class RewardEloquentModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $appends = [
        'image',
        'image_url',
    ];

    protected $table = 'stickers';

    protected $fillable = [
        'id',
        'file_src',
        'name',
        'description',
        'gold_coins_needed',
        'silver_coins_needed',
        'status',
        'rarity',
    ];

    /**
     * THIS USED FOR RARITY STATUS THAT WILL USE ON THE CONTROLLER
     * FOR ENUM TYPE THAT ARE CONSTANT
     *
     * @HARRY
     **/
    protected const RARITY = [
        'common' => 'COMMON',
        'rare' => 'RARE',
        'superrare' => 'SUPERRARE',
        'epic' => 'EPIC',
        'legenedary' => 'LEGENDARY',
    ];

    public function getImageAttribute()
    {
        return $this->getMedia('image');
    }

    public function getImageUrlAttribute()
    {
        $media = $this->getMedia('image')->first();

        return $media ? $media->getFullUrl() : null;
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%');
        });
        $query->when($filters['filter'] ?? false, function ($query, $filter) {
            if ($filter == 'reviewers') {
            } else {
                $query->orderBy($filter, config('sorting.orderBy'));
            }
        });
    }

    public function students()
    {
        return $this->belongsToMany(StudentEloquentModel::class, 'student_sticker', 'sticker_id', 'student_id')->withPivot('id', 'x_axis_position', 'y_axis_position');
    }
}
