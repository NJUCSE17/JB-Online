<?php

namespace App\Http\Resources;

use App\Models\AssignmentFinishRecord;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
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
        $record = AssignmentFinishRecord::query()
            ->where('user_id', \Auth::id())
            ->where('assignment_id', $this->id)
            ->first();
        $finished_at = $record ? $record->updated_at : null;

        return [
            'id'           => $this->id,
            'course_id'    => $this->course_id,
            'name'         => $this->name,
            'content'      => $this->content,
            'content_html' => $this->content_html,
            'due_time'     => $this->due_time->format('Y-m-d H:i:s'),
            'finished_at'  => $finished_at,
        ];
    }
}
