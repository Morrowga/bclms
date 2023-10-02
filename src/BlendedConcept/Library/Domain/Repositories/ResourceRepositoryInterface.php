<?php

namespace Src\BlendedConcept\Library\Domain\Repositories;

use Illuminate\Http\Request;
use Src\BlendedConcept\Library\Infrastructure\EloquentModels\MediaEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

interface ResourceRepositoryInterface
{
    //get resources
    public function getResources(UserEloquentModel $userEloquentModel);

    //create resource
    public function createResource(Request $request,UserEloquentModel $userEloquentModel);

    //update resource
    public function updateResource(Request $request,UserEloquentModel $userEloquentModel, MediaEloquentModel $resource);

    public function delete(MediaEloquentModel $resource);
}
