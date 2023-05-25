<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Infrastructure\EloquentModels;


use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SiteSettingEloquentModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'site_settings';
    // for images
    protected $appends = [
        'image',
    ];

    protected $fillable = [
        "site_name",
        "ssl",
        "timezone",
        'locale',
        "email",
        "contact_number"
    ];

    public function getImageAttribute()
    {
        return $this->getMedia('image');
    }

}
