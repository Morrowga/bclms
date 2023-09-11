<?php

declare(strict_types=1);

namespace Src\BlendedConcept\System\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SiteSettingEloquentModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'system_settings';

    protected $fillable = [
        'site_name',
        'ssl',
        'site_time_zone',
        'site_locale',
        'email',
        'contact_number',
        'url',
        'website_logo',
        'website_favicon',
    ];

    public function getImageAttribute()
    {
        return $this->getMedia('image');
    }
}
