<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimesTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "subject_id"=>$this->subject_id,
            "room_id"=>$this->room_id,
            "day"=>$this->day,
            "start_time"=>$this->start_time,
            "end_time"=>$this->end_time,
        ];
    }
}
