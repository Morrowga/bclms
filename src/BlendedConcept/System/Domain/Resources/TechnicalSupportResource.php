<?php

namespace Src\BlendedConcept\System\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TechnicalSupportResource extends JsonResource
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