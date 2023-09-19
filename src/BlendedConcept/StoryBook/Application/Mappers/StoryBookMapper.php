<?php

namespace Src\BlendedConcept\StoryBook\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Domain\Model\StoryBook;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;

class ClassRoomMapper
{
    public static function fromRequest(Request $request, $storybook_id = null): StoryBook
    {
        return new StoryBook(
            id: $storybook_id,
            name: $request->organization_id,
            description: $request->description,
            thumbnail_img: $request->thumbnail_img,
            num_gold_coins: $request->num_gold_coins,
            num_silver_coins: $request->num_silver_coins,
            is_free: $request->is_free,
            tags : $request->tags,
            sub_learning_needs : $request->sub_learning_needs,
            themes : $request->themes,
            disability_type : $request->disability_type,
            devices : $request->devices,

        );
    }

    public static function toEloquent(StoryBook $storyBook): StoryBookEloquentModel
    {
        $storyBookEloquent = new StoryBookEloquentModel();

        if ($storyBook->id) {
            $storyBookEloquent = StoryBookEloquentModel::query()->findOrFail($storyBook->id);
        }
        $storyBookEloquent->id = $storyBook->id;
        $storyBookEloquent->name = $storyBook->name;
        $storyBookEloquent->description = $storyBook->description;
        $storyBookEloquent->thumbnail_img = $storyBook->thumbnail_img;
        $storyBookEloquent->num_gold_coins = $storyBook->num_gold_coins;
        $storyBookEloquent->num_silver_coins = $storyBook->num_silver_coins;
        $storyBookEloquent->is_free = $storyBook->is_free;

        return $storyBookEloquent;
    }
}
