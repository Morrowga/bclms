<?php

namespace Src\BlendedConcept\System\Application\DTO;

use Illuminate\Http\Request;

class AnnounmentData
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        public readonly string $icon,
        public readonly string $message,
        public readonly ?int $target_role_id,
        public readonly ?int $author_id,

    ) {
    }

    public static function fromRequest(Request $request, $announcement_id): AnnounmentData
    {
        return new self(
            id: $announcement_id,
            title : $request->title,
            icon : $request->icon,
            message: $request->message,
            target_role_id: $request->target_role_id,
            author_id: $request->author_id,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'icon' => $this->icon,
            'message' => $this->message,
            'target_role_id' => $this->target_role_id,
            'author_id' => $this->author_id,
        ];
    }
}
