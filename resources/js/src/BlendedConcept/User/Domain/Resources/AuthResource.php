<?php

namespace Src\BlendedConcept\User\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id ?? "",
            "name" => $this->name  ?? "",
            "email" => $this->email ?? "",
            "roles" => $this->roles ?? "",
            "permissions" => $this->roles ?  new AuthPermissionResource($this->roles()->with('permissions')->first()) : ""
        ];
    }
}
