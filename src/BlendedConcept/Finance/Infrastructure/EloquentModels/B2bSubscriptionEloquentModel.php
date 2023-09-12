<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Finance\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B2bSubscriptionEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'b2b_subscriptions';

    protected $fillable = [
        'subscription_id',
        'organization_id',
        'receipt_image',
        'storage_limit',
        'num_teacher_license',
        'num_student_license',
    ];
}
