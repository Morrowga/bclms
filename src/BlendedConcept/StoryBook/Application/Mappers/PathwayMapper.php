<?php

namespace Src\BlendedConcept\StoryBook\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Pathway;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\PathwayEloquentModel;

class PathwayMapper
{
    public static function fromRequest(Request $request, $pathway_id = null): Pathway
    {
        return new Pathway(
            id: $pathway_id,
            name: $request->name,
            description: $request->description,
            num_gold_coins: $request->num_gold_coins,
            num_silver_coins: $request->num_silver_coins,
            need_complete_in_order: $request->need_complete_in_order,
        );
    }

    public static function toEloquent(Pathway $pathway): PathwayEloquentModel
    {
        $pathwayEloquent = new PathwayEloquentModel();

        if ($pathway->id) {
            $pathwayEloquent = PathwayEloquentModel::query()->findOrFail($pathway->id);
        }
        $pathwayEloquent->id = $pathway->id;
        $pathwayEloquent->name = $pathway->name;
        $pathwayEloquent->description = $pathway->description;
        $pathwayEloquent->num_gold_coins = $pathway->num_silver_coins;
        $pathwayEloquent->num_silver_coins = $pathway->num_silver_coins;
        $pathwayEloquent->need_complete_in_order = $pathway->need_complete_in_order;

        return $pathwayEloquent;
    }
}
