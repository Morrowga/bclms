<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Finance\Infrastructure\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PlanEloquentModel extends Model
{
    use HasFactory;

    protected $table = 'plans';


    protected $fillable = [
        'id',
        'name',
        'storage_limit',
        'num_student_license',
        'allow_customisation',
        'allow_personalisation',
        'status',
        'price',
        'payment_period',
    ];

}
