<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Library\Infrastructure\EloquentModels;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;

class MediaEloquentModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Notifiable;

    protected $table = 'media';

    protected $fillable = ['file_name'];

    protected $append = ['video_url', 'thumb_url'];

    public function getVideoUrlAttribute()
    {
        return asset("storage/resource/{$this->id}/{$this->file_name}");
    }

    public function getThumbUrlAttribute()
    {
        return asset("storage/resource/{$this->id}/conversions/" . $this->name . '-thumb.jpg');
    }

    public function organisation(){
        return $this->belongsTo(OrganisationEloquentModel::class, 'organisation_id', 'id');
    }

    public function teacher(){
        return $this->belongsTo(UserEloquentModel::class, 'teacher_id', 'id');
    }
}
