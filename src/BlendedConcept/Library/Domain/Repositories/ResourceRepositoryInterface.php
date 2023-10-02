<?php

namespace Src\BlendedConcept\Library\Domain\Repositories;

use Illuminate\Http\Request;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

interface ResourceRepositoryInterface
{
    //get resources
    public function getResources(UserEloquentModel $userEloquentModel);

    //create resource
    public function createResource(Request $request,UserEloquentModel $userEloquentModel);
}
