<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Event extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'details' => $this->details,
            'startAt' => $this->start_at->toIso8601String(),
            'endAt' => $this->end_at?->toIso8601String(),
            'allDay' => $this->start_at->toDateString() === $this->end_at?->toDateString(),
        ];
    }
}
