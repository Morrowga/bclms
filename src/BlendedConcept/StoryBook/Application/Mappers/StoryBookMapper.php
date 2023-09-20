<?php

namespace Src\BlendedConcept\StoryBook\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Domain\Model\StoryBook;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\StoryBookEloquentModel;

class StoryBookMapper
{
    public static function fromRequest(Request $request, $storybook_id = null): StoryBook
    {
        return new StoryBook(
            id: $storybook_id,
            name: $request->name,
            description: $request->description,
            num_gold_coins: $request->num_gold_coins,
            num_silver_coins: $request->num_silver_coins,
            thumbnail_img: $request->thumbnail_img,
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
        $storyBookEloquent->num_gold_coins = $storyBook->num_gold_coins;
        $storyBookEloquent->num_silver_coins = $storyBook->num_silver_coins;
        $storyBookEloquent->thumbnail_img = $storyBook->thumbnail_img;
        $storyBookEloquent->is_free = $storyBook->is_free;

        return $storyBookEloquent;
    }
}
