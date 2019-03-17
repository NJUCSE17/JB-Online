<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalAssignmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'user_id'      => $this->user_id,
            'name'         => $this->name,
            'content'      => $this->content,
            'content_html' => $this->content_html,
            'due_time'     => $this->due_time->format('Y-m-d H:i:s'),
        ];
    }
}
