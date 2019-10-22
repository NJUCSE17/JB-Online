<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalAssignmentResource extends JsonResource
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
        if ($this->is_ongoing) {
            return [
                'id'           => $this->id,
                'user_id'      => $this->user_id,
                'name'         => $this->name,
                'content'      => $this->content,
                'content_html' => $this->content_html,
                'due_time'     => $this->due_time->setTimezone(\Auth::user()->timezone)->format('Y-m-d H:i:s'),
                'is_ongoing'   => true,
                'finished_at'  => null,
            ];
        } else {
            return [
                'id'           => $this->id,
                'user_id'      => $this->user_id,
                'name'         => $this->name,
                'content'      => $this->content,
                'content_html' => $this->content_html,
                'due_time'     => $this->due_time->setTimezone(\Auth::user()->timezone)->format('Y-m-d H:i:s'),
                'is_ongoing'   => false,
                'finished_at'  => isset($this->finished_at) ? $this->finished_at->setTimezone(\Auth::user()->timezone) : null,
            ];
        }
    }
}
