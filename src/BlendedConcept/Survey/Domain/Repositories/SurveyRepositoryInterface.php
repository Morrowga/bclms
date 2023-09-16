<?php

namespace Src\BlendedConcept\Survey\Domain\Repositories;

use Src\BlendedConcept\Survey\Domain\Model\Survey;


interface SurveyRepositoryInterface
{
    public function getSurveyList($filters);

    public function createSurvey(Survey $organization);

}
