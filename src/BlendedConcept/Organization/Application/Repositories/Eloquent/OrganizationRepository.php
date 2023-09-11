<?php

namespace Src\BlendedConcept\Organization\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Organization\Application\DTO\OrganizationData;
use Src\BlendedConcept\Organization\Application\Mappers\OrganizationMapper;
use Src\BlendedConcept\Finance\Application\Mappers\PlanMapper;
use Src\BlendedConcept\Finance\Application\Mappers\SubscriptionMapper;
use Src\BlendedConcept\Finance\Domain\Model\Subscription;
use Src\BlendedConcept\Organization\Domain\Model\Organization;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\Organization\Domain\Resources\OrganizationResource;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\PlanEloquentModel;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\Tenant;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function getOrganizationNameId()
    {
        $organizations = OrganizationEloquentModel::get();

        return $organizations;
    }

    public function getOrganizations($filters = [])
    {
        $paginate_organizations = OrganizationResource::collection(OrganizationEloquentModel::filter($filters)->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));
        $default_organizations = OrganizationEloquentModel::get();

        return [
            'paginate_organizations' => $paginate_organizations,
            'default_organizations' => $default_organizations,
        ];
    }

    /**
     * Create a new organization with the provided organization object.
     *
     * @param  Organization  $organization The organization object containing the necessary information.
     * @return void
     */
    public function createOrganization(Organization $organization)
    {

        DB::beginTransaction();

        try {

            //insert data into organization

            $organizationEloquent = OrganizationMapper::toEloquent($organization);
            $organizationEloquent->curr_subscription_id = 1;
            $organizationEloquent->save();

            // Upload the organization's image if provided
            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $organizationEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_organization');
            }
            if ($organizationEloquent->getMedia('image')->isNotEmpty()) {
                $organizationEloquent->logo = $organizationEloquent->getMedia('image')[0]->original_url;
                $organizationEloquent->update();
            }

            //this will create subdomain
            $subdomain = Tenant::create([
                'id' => $organizationEloquent->name,
                'organization_id' => $organizationEloquent->id,
            ]);

            $subdomain->domains()->create(['domain' => $subdomain->id . '.' . env('CENTERAL_DOMAIN')]);
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }

        DB::commit();
    }

    //  update organization
    public function updateOrganization(OrganizationData $organizationData)
    {

        DB::beginTransaction();

        try {
            $organizationDataArray = $organizationData->toArray();
            $organizationEloquent = OrganizationEloquentModel::query()->findOrFail($organizationData->id);
            $organizationEloquent->fill($organizationDataArray);
            $organizationEloquent->update();

            //  delete image if reupload or insert if does not exit
            if (request()->hasFile('image') && request()->file('image')->isValid()) {

                $old_image = $organizationEloquent->getFirstMedia('image');
                if ($old_image != null) {
                    $old_image->delete();

                    $organizationEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_organization');
                } else {

                    $organizationEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_organization');
                }
            }
            if ($organizationEloquent->getMedia('image')->isNotEmpty()) {
                $organizationEloquent->logo = $organizationEloquent->getMedia('image')[0]->original_url;
                $organizationEloquent->update();
            }
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }

        DB::commit();
    }
}
