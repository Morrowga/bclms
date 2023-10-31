<?php

namespace Src\BlendedConcept\Security\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\ParentUserEloquentModel;

class ParentUserData
{
    public function __construct(
        public readonly ?int $parent_id,
        public readonly int $user_id,
        public readonly ?int $organisation_id,
        public readonly ?int $curr_subscription_id,
        public readonly string $type
    ) {
    }

    public static function fromRequest(Request $request, $parent_id = null): ParentUserData
    {

        return new self(
            parent_id: $parent_id,
            user_id: $request->user_id,
            organisation_id: $request->organisation_id,
            curr_subscription_id: $request->curr_subscription_id,
            type: $request->type
        );
    }

    public static function fromEloquent(ParentUserEloquentModel $parent): self
    {
        return new self(
            parent_id: $parent->parent_id,
            user_id: $parent->user_id,
            organisation_id: $parent->organisation_id,
            curr_subscription_id: $parent->curr_subscription_id,
            type: $parent->type
        );
    }

    public function toArray(): array
    {
        return [
            'parent_id' => $this->parent_id,
            'user_id' => $this->user_id,
            'organisation_id' => $this->organisation_id,
            'curr_subscription_id' => $this->curr_subscription_id,
            'type' => $this->type
        ];
    }
}
