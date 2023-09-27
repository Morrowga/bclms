<?php

namespace Src\BlendedConcept\Finance\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\FInance\Application\DTO\SubscriptionData;
use Src\BlendedConcept\Finance\Application\Requests\UpdateB2bSubscriptionRequest;
use Src\BlendedConcept\Finance\Application\Requests\UpdateB2cSubscriptionRequest;
use Src\BlendedConcept\Finance\Application\UseCases\Commands\Subscriptions\UpdateB2bSubscriptionCommand;
use Src\BlendedConcept\Finance\Application\UseCases\Commands\Subscriptions\UpdateB2cSubscriptionCommand;
use Src\BlendedConcept\Finance\Application\UseCases\Queries\Subscriptions\GetB2bSubscriptions;
use Src\BlendedConcept\Finance\Application\UseCases\Queries\Subscriptions\GetB2cSubscriptions;
use Src\BlendedConcept\Finance\Infrastructure\EloquentModels\SubscriptionEloquentModel;

class SubscribtionInvoiceController
{
    public function index()
    {
        try {

            // Get filters from the request
            $filters = request()->only(['page', 'search', 'perPage', 'filter']);

            //quick create org admin

            // Get organisations with pagination using the provided filters
            $b2b_subscriptions = (new GetB2bSubscriptions($filters))->handle();
            $b2c_subscriptions = (new GetB2cSubscriptions($filters))->handle();
            // Render the organisation index page with the retrieved organisations

            return Inertia::render(config('route.subscriptioninvoice.index'), [
                'b2b_subscriptions' => $b2b_subscriptions,
                'b2c_subscriptions' => $b2c_subscriptions,
            ]);
        } catch (\Exception $e) {
            dd($e);

            return redirect()
                ->route('subscription_invoice')
                ->with([
                    'systemErrorMessage' => $e->getMessage(),
                ]);
        }
    }

    public function updateB2b(UpdateB2bSubscriptionRequest $request, SubscriptionEloquentModel $subscription)
    {
        try {
            $updateSubscription = SubscriptionData::fromRequest($request, $subscription);
            $updateSubscriptionCommand = (new UpdateB2bSubscriptionCommand($updateSubscription));
            $updateSubscriptionCommand->execute();

            return redirect()->route('subscription_invoice')->with('successMessage', 'Subscription Updated Successfully!');
        } catch (\Exception $e) {
            dd($e);

            return redirect()
                ->route('subscription_invoice')
                ->with([
                    'systemErrorMessage' => $e->getMessage(),
                ]);
        }
    }

    public function updateB2c(UpdateB2cSubscriptionRequest $request, SubscriptionEloquentModel $subscription)
    {

        try {
            $updateSubscription = SubscriptionData::fromRequest($request, $subscription);
            $updateSubscriptionCommand = (new UpdateB2cSubscriptionCommand($updateSubscription));
            $updateSubscriptionCommand->execute();

            return redirect()->route('subscription_invoice')->with('successMessage', 'Subscription Updated Successfully!');
        } catch (\Exception $e) {
            dd($e);

            return redirect()
                ->route('subscription_invoice')
                ->with([
                    'systemErrorMessage' => $e->getMessage(),
                ]);
        }
    }
}
