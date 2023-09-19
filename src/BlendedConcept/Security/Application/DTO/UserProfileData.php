<?php

namespace Src\BlendedConcept\Security\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class UserProfileData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly string $contact_number,

    ) {
    }

    public static function fromRequest(Request $request, $user_id = null): UserProfileData
    {

        return new self(
            id: $user_id,
            first_name: $request->first_name,
            last_name: $request->last_name,
            email: $request->email,
            contact_number: $request->contact_number,
        );
    }

    public static function fromEloquent(UserEloquentModel $user): self
    {
        return new self(
            id: $user->id,
            first_name: $user->first_name,
            last_name: $user->last_name,
            email: $user->email,
            contact_number: $user->contact_number,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
        ];
    }
}
