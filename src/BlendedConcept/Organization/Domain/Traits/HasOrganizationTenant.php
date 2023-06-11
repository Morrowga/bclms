<?php

namespace Src\BlendedConcept\Organization\Domain\Traits;


use Illuminate\Support\Facades\Auth;

trait HasOrganizationTenant
{
    protected static function bootHasOrganizationTenant()
    {
        // Listen to the creating event of the model
        static::creating(function ($model) {
            // Check if the current user is authenticated and belongs to an organization
            if (Auth::check() && Auth::user()->organization_id) {
                // Set the organization ID based on the authenticated user's organization
                $model->organization_id = Auth::user()->organization_id;
            }
        });
        //this function reterive data from according to organization_id
        static::addGlobalScope('organization', function ($builder) {
            $builder->where('organization_id', auth()->user()->organization_id);
        });


    }
}
