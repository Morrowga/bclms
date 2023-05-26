<?php

namespace Src\BlendedConcept\Organization\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\PlanEloquentModel;
use Src\BlendedConcept\System\Domain\Model\Plan;
use Src\BlendedConcept\System\Domain\Resources\OrganizationResource;


class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function getOrganizationNameId()
    {
        $organizations = OrganizationEloquentModel::get();
        return $organizations;
    }
    public function getOrganizations($filters = [])
    {
        $paginate_organizations = OrganizationResource::collection(OrganizationEloquentModel::filter($filters)->with('plan')->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));
        $default_organizations = OrganizationEloquentModel::get();
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
                $plan = PlanEloquentModel::create([
                    "name" => "Enterprise Solution",
                    "price" => $request->price,
                    "payment_period" => $request->payment_period,
                    "allocated_storage" => $request->storage,
                    "teacher_license" => $request->license
                ]);

                //create a organization
                $organization = OrganizationEloquentModel::create(
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
                $plan = PlanEloquentModel::find($organization->plan_id);
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
