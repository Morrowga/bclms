<?php

namespace Src\BlendedConcept\Survey\Domain\Repositories;

use Illuminate\Http\Request;

interface SurveyResponseRepositoryInterface
{
    //get survey response list
    public function GetSurveyResponses($filters);

    //create survey response
    public function createSurveyResponse(Request $request);


}
