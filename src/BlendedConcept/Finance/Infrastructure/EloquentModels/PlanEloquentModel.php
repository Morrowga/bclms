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
        'description',
        'storage_limit',
        'num_student_profiles',
        'allow_customisation',
        'allow_personalisation',
        'full_library_access',
        'concurrent_access',
        'weekly_learning_report',
        'dedicated_student_report',
        'status',
        'price',
        'payment_period',
    ];

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });

        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });

        $query->when($filters['status'] ?? false, function ($query, $status) {
            $query->where('status', PlanEloquentModel::STATUS[$status]);
        });
    }

    /**
     * Represents the status options for a Plan Status.
     *
     * This constant defines the possible status values for a plan status,
     * can be 'ACTIVE' and 'INACTIVE'.
     *
     * @var array */
    public const STATUS = [
        'active' => 'ACTIVE',
        'inactive' => 'INACTIVE',
    ];

    public const PAYMENTPERIOD = [
        'active' => 'MONTHLY',
        'inactive' => 'YEARLY',
    ];
}
