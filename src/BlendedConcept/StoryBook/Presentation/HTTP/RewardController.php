<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Inertia\Inertia;
use Src\BlendedConcept\StoryBook\Application\DTO\RewardData;
use Src\BlendedConcept\StoryBook\Application\Mappers\RewardMapper;
use Src\BlendedConcept\StoryBook\Application\Requests\StoreRewardRequest;
use Src\BlendedConcept\StoryBook\Application\Requests\UpdateRewardRequest;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\ChangeRewardStatusCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\StoreRewardCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\UpdateRewardCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetRewardQuery;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\RewardEloquentModel;

class RewardController
{
    public function index()
    {

        $filers = request()->only(['search', 'name', 'status', 'perPage']) ?? [];

        $rewards = (new GetRewardQuery($filers))->handle();

        return Inertia::render(config('route.reward.index'), compact('rewards'));
    }

    public function create()
    {

        return Inertia::render(config('route.reward.create'));
    }

    public function store(StoreRewardRequest $request)
    {
        try {
            $rewardMap = RewardMapper::fromRequest($request);
            $createnewReward = new StoreRewardCommand($rewardMap);
            $createnewReward->execute();

            return to_route('rewards.index')->with('successMessage', 'Reward created successfully!');
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function show(RewardEloquentModel $reward)
    {
        return Inertia::render(config('route.reward.show'), compact('reward'));
    }

    public function edit(RewardEloquentModel $reward)
    {

        return Inertia::render(config('route.reward.edit'), compact('reward'));
    }

    public function update(UpdateRewardRequest $request, RewardEloquentModel $reward)
    {
        try {
            // return $request->all();
            $rewardData = RewardData::fromRequest($request, $reward);
            $updateReward = (new UpdateRewardCommand($rewardData));
            $updateReward->execute();

            return to_route('rewards.index')->with('successMessage', 'Reward update successfully!');

        } catch (\Exception $error) {
            dd($error);
        }
    }

    public function changerewardStatus(RewardEloquentModel $reward)
    {

        $changeRewardStatus = (new ChangeRewardStatusCommand($reward))->execute();
    }
}
