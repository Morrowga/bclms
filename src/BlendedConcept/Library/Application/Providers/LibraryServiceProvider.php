<?php

namespace Src\BlendedConcept\Library\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\Library\Domain\Repositories\ResourceRepositoryInterface;
use Src\BlendedConcept\Library\Application\Repositories\Eloquent\ResourceRepository;

class LibraryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ResourceRepositoryInterface::class,
            ResourceRepository::class
        );
    }
}
