<?php

namespace Src\BlendedConcept\Security\Domain\Resources;

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
        $image = '';
        $haveImage = $this->image->count();
        if ($haveImage > 0) {
            $image = $this->image[0]->original_url;
        }

        return [
            'id' => $this->id ?? '',
            'name' => $this->first_name ? $this->first_name.' '.$this->last_name : ' ',
            'email' => $this->email ?? '',
            'roles' => $this->role ?? '',
            'organisation' => $this->organisation ?? '',
            'image' => $image,
            'contact_number' => $this->contact_number,
            'student' => $this->student ?? '',
            'permissions' => $this->role ? new AuthPermissionResource(auth()->user()) : '',
        ];
    }
}
