<?php

namespace Src\BlendedConcept\Security\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class UserData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly ?string $password,
        public readonly ?string $email_verification_send_on,
        public readonly string $contact_number,
        public readonly string $status,
        public readonly string $profile_pic,

    ) {
    }

    public static function fromRequest(Request $request, $user_id = null): UserData
    {

        return new self(
            id: $user_id,
            first_name: $request->first_name,
            last_name: $request->last_name,
            email: $request->email,
            password: $request->password,
            email_verification_send_on: $request->email_verification_send_on,
            contact_number: $request->contact_number,
            status: $request->status,
            profile_pic: $request->profile_pic,
        );
    }

    public static function fromEloquent(UserEloquentModel $user): self
    {
        return new self(
            id: $user->id,
            first_name: $user->first_name,
            last_name: $user->last_name,
            email: $user->email,
            password: $user->password,
            email_verification_send_on: $user->email_verification_send_on,
            contact_number: $user->contact_number,
            status: $user->status,
            profile_pic: $user->profile_pic,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password,
            'email_verification_send_on' => $this->email_verification_send_on,
            'contact_number' => $this->contact_number,
            'status' => $this->status,
            'profile_pic' => $this->profile_pic,
        ];
    }
}
