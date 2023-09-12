<?php

namespace Src\BlendedConcept\System\Application\UseCases\Commands;

use Src\BlendedConcept\System\Domain\Model\Entities\TechnicalSupport;
use Src\BlendedConcept\System\Domain\Repositories\TechnicalSupportRepositoryInterface;
use Src\Common\Domain\CommandInterface;

class CreateTicketDetailCommand implements CommandInterface
{
    private $repository;

    public function __construct(
        private readonly TechnicalSupport $technicalSupport
    ) {
        $this->repository = app()->make(TechnicalSupportRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->askSupportQuestion($this->technicalSupport);
    }
}
