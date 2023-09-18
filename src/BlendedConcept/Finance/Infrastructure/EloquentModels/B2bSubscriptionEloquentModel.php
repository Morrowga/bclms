<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Finance\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class B2bSubscriptionEloquentModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'b2b_subscriptions';

    protected $appends = [
        'image',
    ];

    protected $fillable = [
        'subscription_id',
        'organization_id',
        'receipt_image',
        'storage_limit',
        'num_teacher_license',
        'num_student_license',
    ];

    public function getImageAttribute()
    {
        return $this->getMedia('image');
    }
}
