<?php

namespace Src\BlendedConcept\StoryBook\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\Tag;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\TagEloquentModel;

class TagMapper
{
    public static function fromRequest(Request $request, $tag_id = null): Tag
    {
        return new Tag(
            id : $tag_id,
            name : $this->name,
        );
    }

    public static function toEloquent(Tag $tag): TagEloquentModel
    {
        $tagEloquent = new TagEloquentModel();

        if ($tag->id) {
            $tagEloquent = TagEloquentModel::query()->findOrFail($tag->id);
        }
        $tagEloquent->id = $tag->id;
        $tagEloquent->name = $tag->name;

        return $tagEloquent;
    }
}
