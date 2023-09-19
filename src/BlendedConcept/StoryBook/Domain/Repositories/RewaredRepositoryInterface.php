<?php

namespace Src\BlendedConcept\StoryBook\Domain\Repositories;

use Src\BlendedConcept\StoryBook\Application\DTO\RewardData;

interface RewaredRepositoryInterface
{
    //get all rewards
    public function getRewards($filters);

    //create reward
    public function createReward($request);

    //update reward
    public function updateReward(RewardData $reward);

    public function delete(int $annountment_id);

    public function changeStatus($reward);
}
