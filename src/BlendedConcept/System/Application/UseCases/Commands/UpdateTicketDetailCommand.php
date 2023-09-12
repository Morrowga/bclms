<?php

namespace Src\BlendedConcept\System\Application\UseCases\Commands;

use Src\BlendedConcept\System\Application\DTO\TechnicalSupportData;
use Src\BlendedConcept\System\Domain\Repositories\TechnicalSupportRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class UpdateTicketDetailCommand implements CommandInterface
{
    private $repository;

    public function __construct(
        private readonly TechnicalSupportData $technicalSupport
    ) {
        $this->repository = app()->make(TechnicalSupportRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->answerSupportQuestion($this->technicalSupport);
    }
}
