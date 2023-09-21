<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Student\Infrastructure\EloquentModels;

use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;

class PlaylistEloquentModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'playlists';

    // for images
    protected $appends = [
        'image',
    ];


    protected $fillable = [
        'name',
        'user_id',
        'student_id',
        'teacher_id',
        'playlist_photo',
    ];

    public function getImageAttribute()
    {
        return $this->getMedia('image');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }

    public function student(){
        return $this->belongsTo(StudentEloquentModel::class, 'student_id', 'student_id');
    }

    public function storybooks()
    {
        return $this->belongsToMany(StoryBookEloquentModel::class, 'playlist_storybook', 'playlist_id', 'storybook_id');
    }
}
