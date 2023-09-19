<?php

namespace Src\BlendedConcept\StoryBook\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoryBookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
