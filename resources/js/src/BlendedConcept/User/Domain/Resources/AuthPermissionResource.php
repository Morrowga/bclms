<?php

namespace Src\BlendedConcept\User\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthPermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->permissions->pluck("name");
    }
}
