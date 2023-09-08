<?php

namespace Src\BlendedConcept\StoryBook\Application\Mappers;

use Illuminate\Http\Request;
use Src\BlendedConcept\StoryBook\Domain\Model\Entities\PhysicalResource;
use Src\BlendedConcept\StoryBook\Infrastructure\EloquentModels\PhysicalResourceEloquentModel;

class PhysicalResourceMapper
{
    public static function fromRequest(Request $request, $physical_resource_id = null): PhysicalResource
    {
        return new PhysicalResource(
            id : $physical_resource_id,
            storybook_id : $this->storybook_id,
            file_src : $this->file_src,
        );
    }

    public static function toEloquent(PhysicalResource $physicalResource): PhysicalResourceEloquentModel
    {
        $physicalResourceEloquent = new PhysicalResourceEloquentModel();

        if ($physicalResource->id) {
            $physicalResourceEloquent = PhysicalResourceEloquentModel::query()->findOrFail($physicalResource->id);
        }
        $physicalResourceEloquent->id = $physicalResource->id;
        $physicalResourceEloquent->storybook_id = $physicalResource->storybook_id;
        $physicalResourceEloquent->file_src = $physicalResource->file_src;

        return $physicalResourceEloquent;
    }
}
