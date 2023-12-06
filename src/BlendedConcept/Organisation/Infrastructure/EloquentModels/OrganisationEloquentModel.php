<?php

declare(strict_types=1);

namespace Src\BlendedConcept\Organisation\Infrastructure\EloquentModels;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationAdminEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\ParentEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\ParentUserEloquentModel;
use Src\BlendedConcept\Teacher\Infrastructure\EloquentModels\TeacherEloquentModel;

class OrganisationEloquentModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Notifiable, SoftDeletes;

    protected $table = 'organisations';

    // for images
    protected $appends = [
        'image',
        'image_url'
    ];

    protected $fillable = [
        'id',
        'curr_subscription_id',
        'org_admin_id',
        'name',
        'contact_name',
        'contact_email',
        'contact_number',
        'sub_domain',
        'logo',
        'status',
    ];

    public function getImageAttribute()
    {
        return $this->getMedia('image');
    }

    public function getImageUrlAttribute()
    {
        $media = $this->getMedia('image')->first();

        return $media ? $media->getFullUrl() : null;
    }

    public function subscription()
    {
        return $this->belongsTo(SubscriptionEloquentModel::class, 'curr_subscription_id', 'id');
    }

    public function org_admin()
    {
        return $this->belongsTo(OrganisationAdminEloquentModel::class, 'id', 'org_admin_id')->with('user');
    }

    public function teachers()
    {
        return $this->hasMany(TeacherEloquentModel::class, 'organisation_id', 'id');
    }

    public function parents()
    {
        return $this->hasMany(ParentUserEloquentModel::class, 'organisation_id', 'id');
    }


    public function students()
    {
        return $this->hasOne(StudentEloquentModel::class, 'student_id');
    }

    public function all_students()
    {
        return $this->hasMany(StudentEloquentModel::class, 'organisation_id');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
        $query->when($filters['filter'] ?? false, function ($query, $filter) {
            if ($filter == 'name') {
                $query->orderBy($filter, 'asc');
            } else if($filter == 'teacher_usage'){
                 $query->leftJoin(
                    \DB::raw('(SELECT organisation_id, COUNT(*) as teacher_count FROM teachers GROUP BY organisation_id) as teacher_counts'),
                    'teacher_counts.organisation_id',
                    '=',
                    'organisations.id'
                )
                ->orderBy('teacher_counts.teacher_count', 'asc')
                ->select('organisations.*');
            } else if($filter == 'student_usage'){
                $query->leftJoin(
                    \DB::raw('(SELECT organisation_id, COUNT(*) as student_count FROM students GROUP BY organisation_id) as student_counts'),
                    'student_counts.organisation_id',
                    '=',
                    'organisations.id'
                )
                ->orderBy('student_counts.student_count', 'asc')
                ->select('organisations.*');
            } else if($filter == 'storage_usage'){
                $query->orderBy(function ($query) {
                    // Assuming 'id' is the organization_id field
                    $query->selectRaw('SUM(size) as storage_usage')
                          ->from('media') // Replace with your actual media table name
                          ->where('collection_name', 'videos')
                          ->where('organisation_id', '=', 'organisations.id') // Adjust the column names as needed
                          ->where('status', '=', 'active')
                          ->groupBy('organisation_id');
                }, 'asc');
            } else if($filter == 'status'){
                $query->orderBy('status', 'asc');
            } else {
                $query->orderBy($filter, config('sorting.orderBy'));
            }
        });
    }
}
