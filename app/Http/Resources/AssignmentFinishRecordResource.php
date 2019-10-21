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
        if ($this->ongoing) {
            return [
                'user_id'       => $this->user_id,
                'assignment_id' => $this->assignment_id,
                'ongoing'       => true,
                'finished_at'   => null,
            ];
        } else {
            return [
                'user_id'       => $this->user_id,
                'assignment_id' => $this->assignment_id,
                'ongoing'       => false,
                'finished_at'   => $this->updated_at->setTimezone(\Auth::user()->timezone),
            ];
        }
    }
}
