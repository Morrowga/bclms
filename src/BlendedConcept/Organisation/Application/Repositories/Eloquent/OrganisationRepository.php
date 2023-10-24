<?php

namespace Src\BlendedConcept\Organisation\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\Finance\Domain\Model\Subscription;
use Src\BlendedConcept\Organisation\Domain\Model\Organisation;
use Src\BlendedConcept\Finance\Application\DTO\SubscriptionData;
use Src\BlendedConcept\Organisation\Application\DTO\OrganisationData;
use Src\BlendedConcept\Finance\Application\Mappers\SubscriptionMapper;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\Tenant;
use Src\BlendedConcept\Organisation\Domain\Resources\OrganisationResource;
use Src\BlendedConcept\Organisation\Application\Mappers\OrganisationMapper;
use Src\BlendedConcept\Organisation\Domain\Model\Entities\OrganisationAdmin;
use Src\BlendedConcept\Organisation\Domain\Resources\OrganisationAdminResource;
use Src\BlendedConcept\Organisation\Application\Mappers\OrganisationAdminMapper;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organisation\Domain\Repositories\OrganisationRepositoryInterface;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\B2bSubscriptionEloquentModel;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationEloquentModel;
use Src\BlendedConcept\Organisation\Infrastructure\EloquentModels\OrganisationAdminEloquentModel;

class OrganisationRepository implements OrganisationRepositoryInterface
{
    public function getOrganisationNameId()
    {
        $organisations = OrganisationEloquentModel::pluck('name');

        return $organisations;
    }

    public function getOrganisationNameWithCount()
    {
        $organizaitonNameWithCount = OrganisationEloquentModel::withCount('teachers', 'students')->get();

        return $organizaitonNameWithCount;
    }

    public function getOrganisations($filters = [])
    {
        // $paginate_organisations = OrganisationResource::collection(OrganisationEloquentModel::filter($filters)->with(['org_admin', 'subscription.b2b_subscription'])->withCount('teachers', 'all_students')->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));
        $paginate_organisations = OrganisationEloquentModel::filter($filters)
            ->with(['org_admin', 'subscription.b2b_subscription'])
            ->withCount('teachers', 'all_students')
            ->orderBy('id', 'desc')
            ->paginate($filters['perPage'] ?? 10);

        $paginate_organisations->getCollection()->transform(function ($item) {
            $usedStorage = MediaEloquentModel::where('collection_name', 'videos')
                ->where('organisation_id', $item->id) // Assuming 'id' is the organisation_id field
                ->where('teacher_id', null)
                ->where('status', 'active')
                ->sum('size');

            $convert_mb = $usedStorage == 0 ? $usedStorage : (int)($usedStorage / 1024 / 1024);
            $item['used_storage'] = $convert_mb;

            return $item;
        });
        // return $paginate_organisations;
        // dd($paginate_organisations);

        $default_organisations = OrganisationEloquentModel::get();

        return [
            'paginate_organisations' => $paginate_organisations,
            'default_organisations' => $default_organisations,
        ];
    }


    public function getOrganisationAdmins()
    {
        $default_organisations = OrganisationAdminResource::collection(OrganisationAdminEloquentModel::with(['user', 'organisation'])->orderBy('org_admin_id', 'desc')->get());

        return $default_organisations;
    }

    /**
     * Create a new organisation with the provided organisation object.
     *
     * @param  Organisation  $organisation The organisation object containing the necessary information.
     * @return void
     */
    public function createOrganisation(Organisation $organisation, OrganisationAdmin $organisationAdmin)
    {

        DB::beginTransaction();

        try {

            //insert data into organisation
            $organisationEloquent = OrganisationMapper::toEloquent($organisation);
            $organisationEloquent->save();

            $organisationAdminEloquent = OrganisationAdminMapper::toEloquent($organisationAdmin);
            $organisationAdminEloquent->organisation_id = $organisationEloquent->id;
            $organisationAdminEloquent->save();


            // Upload the organisation's image if provided
            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $organisationEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_organisation');
            }
            if ($organisationEloquent->getMedia('image')->isNotEmpty()) {
                $organisationEloquent->logo = $organisationEloquent->getMedia('image')[0]->original_url;
                $organisationEloquent->update();
            }
            $organisationEloquent->update([
                "org_admin_id" => $organisationAdminEloquent->org_admin_id
            ]);
            // dd($organisationEloquent->sub_domain);
            //this will create subdomain
            $subdomain = Tenant::create([
                'id' => $organisationEloquent->sub_domain,
                'organisation_id' => $organisationEloquent->id,
            ]);

            // Artisan::call('run:subdomain', [
            //     'subdomain' => $organisationEloquent->sub_domain, // Pass the subdomain as an argument
            // ]);

            $subdomain->domains()->create(['domain' => $subdomain->id . '.' . env('CENTERAL_DOMAIN')]);
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
            // throw new \Exception($error->getMessage());
            // throw new \Exception('Something Wrong! Please try again.'); // for production
        }
    }

    //  update organisation
    public function updateOrganisation(OrganisationData $organisationData)
    {

        DB::beginTransaction();

        try {
            $organisationDataArray = $organisationData->toArray();
            $organisationEloquent = OrganisationEloquentModel::query()->findOrFail($organisationData->id);
            $organisationEloquent->fill($organisationDataArray);
            $organisationEloquent->update();

            //  delete image if reupload or insert if does not exit
            if (request()->hasFile('image') && request()->file('image')->isValid()) {

                $old_image = $organisationEloquent->getFirstMedia('image');
                if ($old_image != null) {
                    $old_image->delete();

                    $organisationEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_organisation');
                } else {

                    $organisationEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_organisation');
                }
            }
            if ($organisationEloquent->getMedia('image')->isNotEmpty()) {
                $organisationEloquent->logo = $organisationEloquent->getMedia('image')[0]->original_url;
                $organisationEloquent->update();
            }
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
            // throw new \Exception($error->getMessage());
            // throw new \Exception('Something Wrong! Please try again.'); // for production
        }
    }

    public function addOrganisationSubscription(SubscriptionData $subscriptionData)
    {


        DB::beginTransaction();

        try {
            $subscriptionDataArray = $subscriptionData->toArray();
            $subscriptionEloquent = SubscriptionEloquentModel::query()->findOrFail($subscriptionData->id);
            $subscriptionEloquent->fill($subscriptionDataArray);
            $subscriptionEloquent->update();

            $b2bSubscriptionEloquent = new B2bSubscriptionEloquentModel();
            $b2bSubscriptionEloquent->subscription_id = $subscriptionEloquent->id;
            $b2bSubscriptionEloquent->organisation_id = $subscriptionDataArray['b2b_subscription']['organisation_id'];
            $b2bSubscriptionEloquent->storage_limit = $subscriptionDataArray['b2b_subscription']['storage_limit'];
            $b2bSubscriptionEloquent->num_student_license = $subscriptionDataArray['b2b_subscription']['num_student_license'];
            $b2bSubscriptionEloquent->num_teacher_license = $subscriptionDataArray['b2b_subscription']['num_teacher_license'];
            $b2bSubscriptionEloquent->save();
            if (request()->hasFile('image')) {
                foreach (request()->file('image') as $file) {
                    if ($file->isValid()) {
                        $uploadFile = $b2bSubscriptionEloquent->addMedia($file)
                            ->toMediaCollection('image', 'media_payment_receipt');
                        // $b2bSubscriptionEloquent->receipt_image = $uploadFile->getFirstMediaUrl('image'); // Corrected the method to get the media URL
                        // $b2bSubscriptionEloquent->update();
                    }
                }
            }
            // if ($b2bSubscriptionEloquent->getMedia('image')->isNotEmpty()) {
            //     $b2bSubscriptionEloquent->receipt_image = $b2bSubscriptionEloquent->getMedia('image')[0]->original_url;
            //     $b2bSubscriptionEloquent->update();
            // }
            //  delete image if reupload or insert if does not exit
            // if (request()->hasFile('image') && request()->file('image')->isValid()) {
            //     $b2bSubscriptionEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_payment_receipt');
            // }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
            // throw new \Exception($error->getMessage());
            // throw new \Exception('Something Wrong! Please try again.'); // for production
        }
    }

    public function newOrganisationSubscription(Subscription $subscription)
    {

        DB::beginTransaction();

        try {
            $subscriptionEloquent = SubscriptionMapper::toEloquent($subscription);
            $subscriptionEloquent->save();


            $b2bSubscriptionEloquent = new B2bSubscriptionEloquentModel();
            $b2bSubscriptionEloquent->subscription_id = $subscriptionEloquent->id;
            $b2bSubscriptionEloquent->organisation_id = request()->b2b_subscription['organisation_id'];
            $b2bSubscriptionEloquent->storage_limit = request()->b2b_subscription['storage_limit'];
            $b2bSubscriptionEloquent->num_student_license = request()->b2b_subscription['num_student_license'];
            $b2bSubscriptionEloquent->num_teacher_license = request()->b2b_subscription['num_teacher_license'];
            $b2bSubscriptionEloquent->save();


            $organisationEloquent = OrganisationEloquentModel::find(request()->b2b_subscription['organisation_id']);
            $organisationEloquent->curr_subscription_id = $subscriptionEloquent->id;
            $organisationEloquent->save();
            //  delete image if reupload or insert if does not exit
            if (request()->hasFile('image') && request()->file('image')->isValid()) {
                $b2bSubscriptionEloquent->addMediaFromRequest('image')->toMediaCollection('image', 'media_payment_receipt');
            }
            // if ($b2bSubscriptionEloquent->getMedia('image')->isNotEmpty()) {
            //     $b2bSubscriptionEloquent->receipt_image = $b2bSubscriptionEloquent->getMedia('image')[0]->original_url;
            //     $b2bSubscriptionEloquent->update();
            // }
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
            // throw new \Exception($error->getMessage());
            // throw new \Exception('Something Wrong! Please try again.'); // for production
        }
    }

    public function delete(OrganisationEloquentModel $organisation)
    {
        try {
            $organisation->delete();
        } catch (\Exception $error) {
            config('app.env') == 'production'
                ? throw new \Exception('Something Wrong! Please try again.')
                : throw new \Exception($error->getMessage());
            // throw new \Exception($error->getMessage());
            // throw new \Exception('Something Wrong! Please try again.'); // for production
        }
    }
}
