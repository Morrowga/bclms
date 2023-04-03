<?php

namespace Src\BlendedConcept\User\Domain\Repositories;




interface StudentRepositoryInterface
{

    public function createStudent($request);
    public function updateStudent($request, $student);
}
