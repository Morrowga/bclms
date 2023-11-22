<?php

namespace Src\BlendedConcept\Survey\Domain\Repositories;

use Illuminate\Http\Request;

interface SurveyResponseRepositoryInterface
{
    //get survey response list
    public function GetSurveyResponses($filters);

    //get each user survey responses
    public function GetUserSurveyResponses($survey_id, $user_id, $response_datetime);

    //create survey response
    public function createSurveyResponse(Request $request);


    public function deleteResponse(int $response_id);
}
