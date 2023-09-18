<?php

namespace Src\BlendedConcept\Organization\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Finance\Application\Mappers\SubscriptionMapper;
use Src\BlendedConcept\Finance\Domain\Model\Subscription;
use Src\BlendedConcept\Organization\Application\DTO\OrganizationData;
use Src\BlendedConcept\Organization\Application\Mappers\OrganizationMapper;
use Src\BlendedConcept\Organization\Domain\Model\Organization;
use Src\BlendedConcept\Organization\Domain\Repositories\OrganizationRepositoryInterface;
use Src\BlendedConcept\Organization\Domain\Resources\OrganizationResource;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\OrganizationEloquentModel;
use Src\BlendedConcept\Organization\Infrastructure\EloquentModels\Tenant;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function getOrganizationNameId()
    {
        $organizations = OrganizationEloquentModel::pluck('name');

        return $organizations;
    }

    public function getOrganizationNameWithCount()
    {
        $organizaitonNameWithCount = OrganizationEloquentModel::withCount('teachers', 'students')->get();

        return $organizaitonNameWithCount;
    }

    public function getOrganizations($filters = [])
    {
        $paginate_organizations = OrganizationResource::collection(OrganizationEloquentModel::filter($filters)->with(['org_admin', 'subscription.b2b_subscription'])->withCount('teachers', 'students')->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

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
    public function createOrganization(Organization $organization, Subscription $subscription)
    {

        DB::beginTransaction();

        try {

            //insert data into organization
            $subscriptionEloquent = SubscriptionMapper::toEloquent($subscription);
            $subscriptionEloquent->save();
            $organizationEloquent = OrganizationMapper::toEloquent($organization);
            $organizationEloquent->curr_subscription_id = $subscriptionEloquent->id;
            $organizationEloquent->save();

            // Upload the organization's image if provided
            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $organizationEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_organization');
            }
            if ($organizationEloquent->getMedia('image')->isNotEmpty()) {
                $organizationEloquent->logo = $organizationEloquent->getMedia('image')[0]->original_url;
                $organizationEloquent->update();
            }
            // dd($organizationEloquent->sub_domain);
            //this will create subdomain
            $subdomain = Tenant::create([
                'id' => $organizationEloquent->sub_domain,
                'organization_id' => $organizationEloquent->id,
            ]);

            $subdomain->domains()->create(['domain' => $subdomain->id.'.'.env('CENTERAL_DOMAIN')]);
            DB::commit();

        } catch (\Exception $error) {
            DB::rollBack();
            dd($error->getMessage());
        }

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
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            dd($error);
        }

    }
}
