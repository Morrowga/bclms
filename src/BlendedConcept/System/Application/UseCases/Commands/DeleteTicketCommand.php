<?php

namespace Src\BlendedConcept\System\Application\UseCases\Commands;

use Src\BlendedConcept\System\Domain\Model\Entities\TechnicalSupport;
use Src\BlendedConcept\System\Domain\Repositories\TechnicalSupportRepositoryInterface;
use Src\Common\Domain\CommandInterface;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\TechnicalSupportEloquentModel;

class DeleteTicketCommand implements CommandInterface
{
    private $repository;

    public function __construct(
        private readonly TechnicalSupportEloquentModel $technicalSupport
    ) {
        $this->repository = app()->make(TechnicalSupportRepositoryInterface::class);
    }

    public function execute()
    {
        return $this->repository->deleteSupportQuestion($this->technicalSupport);
    }
}
