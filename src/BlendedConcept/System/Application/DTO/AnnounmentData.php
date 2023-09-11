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
        public readonly string $by,
        public readonly string $to,

    ) {
    }

    public static function fromRequest(Request $request, $announcement_id): AnnounmentData
    {
        return new self(
            id: $announcement_id,
            title : $request->title,
            icon : $request->icon,
            message: $request->message,
            by: $request->by,
            to: $request->to,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'icon' => $this->icon,
            'message' => $this->message,
            'by' => $this->by,
            'to' => $this->to,
        ];
    }
}
