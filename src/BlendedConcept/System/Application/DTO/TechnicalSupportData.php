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
        public readonly string $has_responsed,
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
            has_responsed : $request->has_responsed,
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
            has_responsed : $support->has_responsed,
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
            'has_responsed' => $this->has_responsed,
            'question' => $this->question,
            'response' => $this->response,
        ];
    }
}
