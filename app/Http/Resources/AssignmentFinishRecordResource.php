<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentFinishRecordResource extends JsonResource
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
                'user_id'       => $this->user_id,
                'assignment_id' => $this->assignment_id,
                'is_ongoing'    => true,
                'finished_at'   => null,
            ];
        } else {
            return [
                'user_id'       => $this->user_id,
                'assignment_id' => $this->assignment_id,
                'is_ongoing'    => false,
                'finished_at'   => $this->updated_at->setTimezone(\Auth::user()->timezone),
            ];
        }
    }
}
