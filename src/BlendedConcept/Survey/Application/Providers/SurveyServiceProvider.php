<?php

namespace Src\BlendedConcept\Survey\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\Survey\Application\Repositories\Eloquent\SurveyRepository;
use Src\BlendedConcept\Survey\Domain\Repositories\SurveyRepositoryInterface;

class SurveyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            SurveyRepositoryInterface::class,
            SurveyRepository::class
        );
    }
}
