<?php

namespace Src\BlendedConcept\System\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\System\Domain\Model\Organization;
use Src\BlendedConcept\System\Domain\Model\Plan;
use Src\BlendedConcept\System\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\System\Domain\Resources\OrganizationResource;


class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function getOrganizationNameId()
    {
        $organizations = Organization::get();
        return $organizations;
    }
    public function getOrganizations($filters = [])
    {
        $paginate_organizations = OrganizationResource::collection(Organization::filter($filters)->with('plan')->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));
        $default_organizations = Organization::get();
        return [
            "paginate_organizations" => $paginate_organizations,
            "default_organizations" => $default_organizations
        ];
    }

    // store organization
    public function createOrganization($request)
    {
        try {
            DB::transaction(function () use ($request) {
                //create a plan
                $plan = Plan::create([
                    "name" => "Enterprise Solution",
                    "price" => $request->price,
                    "payment_period" => $request->payment_period,
                    "allocated_storage" => $request->storage,
                    "teacher_license" => $request->license
                ]);

                //create a organization
                $organization = Organization::create(
                    [
                        "plan_id" => $plan->id,
                        "name"  => $request->name,
                        "contact_person" => $request->contact_person,
                        "contact_email" => $request->contact_email,
                        "contact_number" => $request->contact_number,
                    ]
                );
                if ($request->hasFile('image') && $request->file('image')->isValid()) {

                    $organization->addMediaFromRequest('image')->toMediaCollection('image', 'media_organization');
                }
            });
        } catch (\Throwable $th) {
           dd($th);
        }
    }

    //  update organization
    public function updateOrganization($request, $organization)
    {
        try {
            DB::transaction(function () use ($request, $organization) {
                $organization->update([
                    "name"  => $request->name,
                    "contact_person" => $request->contact_person,
                    "contact_email" => $request->contact_email,
                    "contact_number" => $request->contact_number,
                ]);
                $plan = Plan::find($organization->plan_id);
                $plan->update([
                    "name" => "Enterprise Solution",
                    "price" => $request->price,
                    "payment_period" => $request->payment_period,
                    "allocated_storage" => $request->storage,
                    "teacher_license" => $request->license
                ]);
                //  delete image if reupload or insert if does not exit
                if ($request->hasFile('image') && $request->file('image')->isValid()) {

                    $old_image = $organization->getFirstMedia('image');
                    if ($old_image != null) {
                        $old_image->delete();

                        $organization->addMediaFromRequest('image')->toMediaCollection('image', 'media_organization');
                    } else {

                        $organization->addMediaFromRequest('image')->toMediaCollection('image', 'media_organization');
                    }
                }
            });
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
