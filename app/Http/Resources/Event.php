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
            'start' => $this->start_at->toIso8601String(),
            'end' => $this->end_at ? $this->end_at->endOfDay()->toIso8601String() : null,
            'allDay' => $this->start_at->toDateString() === $this->end_at->toDateString(),
        ];
    }
}
