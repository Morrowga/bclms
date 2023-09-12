<?php

namespace Src\BlendedConcept\Finance\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\Finance\Application\Repositories\Eloquent\SubscriptionRepository;
use Src\BlendedConcept\Finance\Domain\Repositories\SubscriptionRepositoryInterface;

class SubscriptionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            SubscriptionRepositoryInterface::class,
            SubscriptionRepository::class
        );
    }
}
