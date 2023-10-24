<?php

namespace Src\BlendedConcept\StoryBook\Presentation\HTTP;

use Illuminate\Http\Response;
use Inertia\Inertia;
use Src\BlendedConcept\StoryBook\Application\DTO\RewardData;
use Src\BlendedConcept\StoryBook\Application\Mappers\RewardMapper;
use Src\BlendedConcept\StoryBook\Application\Requests\StoreRewardRequest;
use Src\BlendedConcept\StoryBook\Application\Requests\UpdateRewardRequest;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetRewardQuery;
use Src\BlendedConcept\StoryBook\Application\UseCases\Queries\GetStickerRollData;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\StoreRewardCommand;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\UpdateRewardCommand;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\RewardEloquentModel;
use Src\BlendedConcept\StoryBook\Application\UseCases\Commands\ChangeRewardStatusCommand;
use Src\BlendedConcept\StoryBook\Domain\Policies\RewardPolicy;

class RewardController
{
    /**
     * Display a listing of rewards based on provided filters.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        abort_if(authorize('view', RewardPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Get filters from the request
        $filters = request()->only(['search', 'name', 'status', 'perPage', 'filter']) ?? [];

        // Use a query handler to fetch rewards based on the filters
        $rewards = (new GetRewardQuery($filters))->handle();

        // Render the rewards using Inertia
        return Inertia::render(config('route.reward.index'), compact('rewards'));
    }

    /**
     * Display the create reward page.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        abort_if(authorize('create', RewardPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Render the create reward page using Inertia
        return Inertia::render(config('route.reward.create'));
    }

    /**
     * Store a new reward based on the provided request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRewardRequest $request)
    {
        abort_if(authorize('store', RewardPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');


        try {
            // Map the reward data from the request
            $rewardMap = RewardMapper::fromRequest($request);

            // Create a new reward using a command
            $createNewReward = new StoreRewardCommand($rewardMap);
            $createNewReward->execute();

            // Redirect to the index page with a success message
            return redirect()->route('rewards.index')->with('successMessage', 'Reward created successfully!');
        } catch (\Exception $exception) {
            // Handle any exceptions and display the error message
            dd($exception->getMessage());
        }
    }

    /**
     * Display the details of a specific reward.
     *
     * @return \Inertia\Response
     */
    public function show(RewardEloquentModel $reward)
    {
        abort_if(authorize('show', RewardPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Render the reward details using Inertia
        return Inertia::render(config('route.reward.show'), compact('reward'));
    }

    /**
     * Display the form to edit a specific reward.
     *
     * @return \Inertia\Response
     */
    public function edit(RewardEloquentModel $reward)
    {
        abort_if(authorize('edit', RewardPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Render the reward edit form using Inertia
        return Inertia::render(config('route.reward.edit'), compact('reward'));
    }

    /**
     * Update an existing reward based on the provided request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRewardRequest $request, RewardEloquentModel $reward)
    {
        abort_if(authorize('update', RewardPolicy::class), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            // Map the reward data from the request
            $rewardData = RewardData::fromRequest($request, $reward->id);
            // Update the reward using a command
            $updateReward = new UpdateRewardCommand($rewardData);
            $updateReward->execute();

            // Redirect to the index page with a success message
            return redirect()->route('rewards.index')->with('successMessage', 'Reward updated successfully!');
        } catch (\Exception $error) {
            // Handle any exceptions and display the error
            dd($error);
        }
    }

    /**
     * Change the status of a specific reward.
     *
     * @return void
     */
    public function changerewardStatus(RewardEloquentModel $reward)
    {
        // Execute a command to change the reward status
        $changeRewardStatus = (new ChangeRewardStatusCommand($reward))->execute();
    }
}
