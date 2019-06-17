<?php

namespace App\Http\Resources;

use App\Models\AssignmentFinishRecord;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
        return [
            'id'            => $this->id,
            'course_id'     => $this->course_id,
            'name'          => $this->name,
            'content'       => $this->content,
            'content_html'  => $this->content_html,
            'due_time'      => $this->due_time->format('Y-m-d H:i:s'),
            'finished_at'   => $this->finishedAt(Auth::user()),
            'rate_info'     => $this->ratedInfo(),
        ];
    }
}
