<?php

namespace Src\BlendedConcept\System\Application\DTO;

use Illuminate\Http\Request;
use Src\BlendedConcept\System\Infrastructure\EloquentModels\AnnouncementEloquentModel;

class AnnounmentData
{

    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        public readonly string $message,
        public readonly ?string $type,
        public readonly ?int $created_by,
        public readonly ?int $trigger_on,
        public readonly ?int $send_to,
    ) {
    }

    public static function fromRequest(Request $request, $announcement_id = null): AnnounmentData
    {

        return new self(
            id: $announcement_id,
            type : $request->type,
            title: $request->title,
            message: $request->message,
            created_by: $request->created_by,
            trigger_on: $request->trigger_on,
            send_to: $request->send_to,
        );
    }

    public static function fromEloquent(AnnouncementEloquentModel $announment) : self
    {
        return new self(
            id: $announment->id,
            type:null,
            title: $announment->title,
            message: $announment->message,
            created_by: $announment->created_by,
            trigger_on: $announment->trigger_on,
            send_to: $announment->send_to,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            "type" => $this->type,
            'message' => $this->message,
            'created_by' => $this->created_by,
            'trigger_on' => $this->trigger_on,
            'send_to' => $this->send_to,
        ];
    }
}
