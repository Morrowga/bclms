<?php

namespace Src\BlendedConcept\System\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\TechnicalSupportEloquentModel;

class TechnicalSupportData
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $user_id,
        public readonly string $date,
        public readonly string $has_responded,
        public readonly string $question,
        public readonly ?string $response,

    ) {
    }

    public static function fromRequest(Request $request, $support_id = null): TechnicalSupportData
    {
        return new self(
            id : $support_id,
            user_id : $request->user_id,
            date : $request->date,
            has_responded : $request->has_responded,
            question : $request->question,
            response : $request->response
        );
    }

    public static function fromEloquent(TechnicalSupportEloquentModel $support): self
    {
        return new self(
            id : $support->id,
            user_id : $support->user_id,
            date : $support->date,
            has_responded : $support->has_responded,
            question : $support->question,
            response : $support->response
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'date' => $this->date,
            'has_responded' => $this->has_responded,
            'question' => $this->question,
            'response' => $this->response,
        ];
    }
}
