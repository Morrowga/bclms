<?php

namespace Src\BlendedConcept\ClassRoom\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BlendedConcept\ClassRoom\Application\Repositories\Eloquent\ClassRoomRepository;
use Src\BlendedConcept\ClassRoom\Domain\Repositories\ClassRoomRepositoryInterface;

class ClassRoomServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ClassRoomRepositoryInterface::class,
            ClassRoomRepository::class
        );

    }
}
