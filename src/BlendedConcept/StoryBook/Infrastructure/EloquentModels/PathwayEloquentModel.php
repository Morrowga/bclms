<?php

declare(strict_types=1);

namespace Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PathwayEloquentModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;


    protected $table = 'pathways';
    protected $appends = [
        'image_url'
    ];
    protected $fillable = [
        'id',
        'name',
        'description',
        'num_gold_coins',
        'num_silver_coins',
        'need_complete_in_order',
    ];
    public function getImageUrlAttribute()
    {
        return $this->getFirstMedia('pathway_img')->original_url ?? '';
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

    public function storybooks()
    {
        return $this->belongsToMany(StoryBookEloquentModel::class, 'pathway_storybook', 'pathway_id', 'storybook_id');
    }

    public function students()
    {
        return $this->belongsToMany(StudentEloquentModel::class, 'student_pathway', 'pathway_id', 'storybook_id');
    }
}
