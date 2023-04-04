<?php

declare(strict_types=1);

namespace Src\BlendedConcept\User\Domain\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Announcement extends Model implements HasMedia
{
    use InteractsWithMedia;

    // for images
    protected $appends = [
        'image',
    ];

    protected $guarded = [];
    public function getImageAttribute()
    {
        return $this->getMedia('image');
    }
}
