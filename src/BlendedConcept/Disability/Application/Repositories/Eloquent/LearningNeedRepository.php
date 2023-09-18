<?php

namespace Src\BlendedConcept\Disability\Application\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Src\BlendedConcept\Disability\Application\DTO\LearningNeedData;
use Src\BlendedConcept\Disability\Application\Mappers\LearningNeedMapper;
use Src\BlendedConcept\Disability\Domain\Model\Entities\LearningNeed;
use Src\BlendedConcept\Disability\Domain\Repositories\LearningNeedRepositoryInterface;
use Src\BlendedConcept\Disability\Domain\Resources\LearningNeedResource;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\LearningNeedEloquentModel;
use Src\BlendedConcept\Disability\Infrastructure\EloquentModels\SubLearningTypeEloquentModel;

class LearningNeedRepository implements LearningNeedRepositoryInterface
{
    public function getLearningNeeds($filters)
    {

        $learningNeeds = LearningNeedResource::collection(LearningNeedEloquentModel::filter($filters)->with('sub_learnings')->orderBy('id', 'desc')->paginate($filters['perPage'] ?? 10));

        return $learningNeeds;
    }

    public function createLearningNeed(LearningNeed $LearningNeed)
    {
        DB::beginTransaction();
        try {
            $LearningNeedEloquent = LearningNeedMapper::toEloquent($LearningNeed);
            $LearningNeedEloquent->save();
            foreach (request('sub_learnings') as $value) {
                $LearningNeedEloquent->sub_learnings()->create([
                    'name' => $value,
                ]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }

    public function updateLearningNeed(LearningNeedData $LearningNeedData)
    {
        DB::beginTransaction();
        try {
            $LearningNeedArray = $LearningNeedData->toArray();
            $LearningNeedEloquent = LearningNeedEloquentModel::findOrFail($LearningNeedData->id);
            $LearningNeedEloquent->fill($LearningNeedArray);
            $LearningNeedEloquent->update();
            foreach (request('sub_learnings') as $sub_learning) {
                if (! $sub_learning['id']) {
                    $LearningNeedEloquent->sub_learnings()->create([
                        'name' => $sub_learning['name'],
                    ]);
                }
            }
            foreach (request('delete_sub_learnings') as $value) {
                $subLearningEloquent = SubLearningTypeEloquentModel::find($value);
                $subLearningEloquent->delete();
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }

    public function deleteLearningNeed(LearningNeedEloquentModel $LearningNeed)
    {
        DB::beginTransaction();
        try {
            $LearningNeed->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }
}
