<?php

namespace Src\BlendedConcept\Finance\Presentation\HTTP;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Src\BlendedConcept\Finance\Application\DTO\SubscriptionData;
use Src\BlendedConcept\Finance\Application\Mappers\SubscriptionMapper;
use Src\BlendedConcept\Finance\Application\Policies\SubscriptionPolicy;
use Src\BlendedConcept\Finance\Application\Requests\UpdateB2bSubscriptionRequest;
use Src\BlendedConcept\Finance\Application\Requests\UpdateB2cSubscriptionRequest;
use Src\BlendedConcept\Finance\Application\UseCases\Commands\Subscriptions\UpdateB2bSubscriptionCommand;
use Src\BlendedConcept\Finance\Application\UseCases\Commands\Subscriptions\UpdateB2cSubscriptionCommand;
use Src\BlendedConcept\Finance\Application\UseCases\Queries\Plans\GetPlanWithPagination;
use Src\BlendedConcept\Finance\Application\UseCases\Queries\Subscriptions\GetB2bSubscriptions;
use Src\BlendedConcept\Finance\Application\UseCases\Queries\Subscriptions\GetB2cSubscriptions;
use Src\BlendedConcept\Finance\Application\UseCases\Queries\Subscriptions\GetOrgForSubscription;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;
use Src\BlendedConcept\Organisation\Application\Requests\StoreOrganisationSubscriptionRequest;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\NewOrganisationSubscriptionCommand;
use Src\BlendedConcept\Organisation\Application\UseCases\Commands\StoreOrganisationSubscriptionCommand;


class SubscribtionInvoiceController
{
    public function index()
    {
        // return SubscriptionEloquentModel::with('b2b_subscription')->whereHas('b2b_subscription', function ($query) {
        //     $query->orderBy('num_teacher_license', 'asc');
        // })->get();
        // dd('hello');
        abort_if(authorize('view', SubscriptionPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            // Get filters from the request
            $filters = request()->only(['page', 'search', 'perPage', 'filter']);

            //quick create org admin

            // Get organisations with pagination using the provided filters
            $b2b_subscriptions = (new GetB2bSubscriptions($filters))->handle();
            $b2c_subscriptions = (new GetB2cSubscriptions($filters))->handle();
            $plans = (new GetPlanWithPagination($filters))->handle()['default_plans'];


            // Render the organisation index page with the retrieved organisations

            return Inertia::render(config('route.subscriptioninvoice.index'), [
                'b2b_subscriptions' => $b2b_subscriptions,
                'b2c_subscriptions' => $b2c_subscriptions,
                'plans' => $plans
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }

    public function updateB2b(UpdateB2bSubscriptionRequest $request, SubscriptionEloquentModel $subscription)
    {
        abort_if(authorize('update', SubscriptionPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $updateSubscription = SubscriptionData::fromRequest($request, $subscription);
            $updateSubscriptionCommand = (new UpdateB2bSubscriptionCommand($updateSubscription));
            $updateSubscriptionCommand->execute();

            return redirect()->route('subscription_invoice')->with('successMessage', 'Subscription Updated Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }

    public function updateB2c(Request $request, SubscriptionEloquentModel $subscription)
    {

        abort_if(authorize('update', SubscriptionPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $updateSubscription = SubscriptionData::fromRequest($request, $subscription);
            $updateSubscriptionCommand = (new UpdateB2cSubscriptionCommand($updateSubscription));
            $updateSubscriptionCommand->execute();

            return redirect()->route('subscription_invoice')->with('successMessage', 'Subscription Updated Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }

    public function addOrgSubscription()
    {
        abort_if(authorize('store', SubscriptionPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $organisations = (new GetOrgForSubscription())->handle();
            return Inertia::render(config('route.subscriptioninvoice.add_subscription'), [
                'organisations' => $organisations
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }

    public function storeOrgSubscription(StoreOrganisationSubscriptionRequest $request)
    {
        abort_if(authorize('store', SubscriptionPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {

            // Abort if the user is not authorized to create organisations
            // abort_if(authorize('create', OrganisationPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

            // Validate the request data
            $subscription = SubscriptionEloquentModel::find($request->b2b_subscription['subscription_id']);
            if ($subscription) {
                $updateSubscription = SubscriptionData::fromRequest($request, $subscription);
                $saveOrganisation = (new StoreOrganisationSubscriptionCommand($updateSubscription));
                $saveOrganisation->execute();
            } else {
                $storeSubscription = SubscriptionMapper::fromRequest($request);
                $saveOrganisation = (new NewOrganisationSubscriptionCommand($storeSubscription));
                $saveOrganisation->execute();
            }

            return redirect()->route('subscription_invoice')->with('successMessage', 'Subscription Created Successfully!');
        } catch (\Exception $error) {
            return redirect()->back()->with('errorMessage', $error->getMessage());
        }
    }
}
