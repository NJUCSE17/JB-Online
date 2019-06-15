<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'semester'    => $this->semester,
            'start_time'  => $this->start_time->format('Y-m-d H:i:s'),
            'end_time'    => $this->end_time->format('Y-m-d H:i:s'),
            'notice'      => $this->notice,
            'notice_html' => $this->notice_html,
        ];
    }
}