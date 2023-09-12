<?php

namespace Src\BlendedConcept\System\Domain\Repositories;

use Src\BlendedConcept\System\Application\DTO\TechnicalSupportData;
use Src\BlendedConcept\System\Domain\Model\Entities\TechnicalSupport;

interface TechnicalSupportRepositoryInterface
{
    public function askSupportQuestion(TechnicalSupport $technicalSupport);

    public function answerSupportQuestion(TechnicalSupportData $technicalSupportData);

    public function getSupportQuestion($filters = []);

    public function deleteSupportQuestion($support_id);
}
