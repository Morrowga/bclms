<?php

namespace Src\BlendedConcept\System\Application\Repositories\Eloquent;

use Src\BlendedConcept\System\Application\DTO\TechnicalSupportData;
use Src\BlendedConcept\System\Application\Mappers\TechnicalSupportMapper;
use Src\BlendedConcept\System\Domain\Model\Entities\TechnicalSupport;
use Src\BlendedConcept\System\Domain\Repositories\TechnicalSupportRepositoryInterface;
use Src\BlendedConcept\System\Domain\Resources\TechnicalSupportResource;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\TechnicalSupportEloquentModel;

class TechnicalSupportRepository implements TechnicalSupportRepositoryInterface
{
    /**
     * this function work add current data and current authnicated user
     * if user ask questions
     *
     * @hareom284
     */
    public function askSupportQuestion(TechnicalSupport $technicalSupport)
    {

        try {
            $technicalSupportEloquent = TechnicalSupportMapper::toEloquent($technicalSupport);
            $technicalSupportEloquent->date = now();
            $technicalSupportEloquent->user_id = auth()->user()->id;
            $technicalSupportEloquent->has_responded = false;
            $technicalSupportEloquent->save();

        } catch (\Exception $e) {

            dd($e->getMessage());

        }

    }

    public function getSupportQuestion($filters = [])
    {

        /*****
         * check if the user_role is superadmin or bc_staff then show all the user list
         * or show
         */
        if (auth()->user()->role->name == config('userrole.bcsuperadmin') || auth()->user()->role->name == config('userorle.bcstaff')) {

            $technicalSupport = TechnicalSupportResource::collection(TechnicalSupportEloquentModel::with(['user'])
                ->filter($filters)
                ->paginate($filters['perPage'] ?? 10));

        } else {
            $technicalSupport = TechnicalSupportResource::collection(TechnicalSupportEloquentModel::where('user_id', auth()->user()->id)
                ->with(['user'])
                ->filter($filters)
                ->paginate($filters['perPage'] ?? 10));

        }

        return $technicalSupport;

    }

    public function answerSupportQuestion(TechnicalSupportData $technicalSupportData)
    {

    }

    public function deleteSupportQuestion($support)
    {
        $support->delete();
    }
}
