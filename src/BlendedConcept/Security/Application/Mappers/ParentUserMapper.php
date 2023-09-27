<?php

namespace Src\BlendedConcept\Security\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\Security\Domain\Model\Entities\ParentUser;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\ParentUserEloqeuntModel;

class ParentUserMapper
{
    public static function fromRequest(Request $request, $parent_id = null): ParentUser
    {
        return new ParentUser(
            parent_id: $parent_id,
            user_id: $request->user_id,
            organisation_id: $request->organisation_id,
            curr_subscription_id: $request->curr_subscription_id,
            type: $request->type
        );
    }

    public static function toEloquent(ParentUser $parent): ParentUserEloqeuntModel
    {
        $ParentEloquent = new ParentUserEloqeuntModel();

        if ($parent->parent_id) {
            $ParentEloquent = ParentUserEloqeuntModel::query()->findOrFail($parent->parent_id);
        }
        $ParentEloquent->user_id = $parent->user_id;
        $ParentEloquent->organisation_id = $parent->organisation_id;
        $ParentEloquent->curr_subscription_id = $parent->curr_subscription_id;
        $ParentEloquent->type = $parent->type;

        return $ParentEloquent;
    }
}
