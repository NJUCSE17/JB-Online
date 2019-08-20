<?php

namespace App\Http\Resources;

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
        $course = $this->course;
        $user = Auth::user();

        return [
            'id'              => $this->id,
            'course_id'       => $this->course_id,
            'course_name'     => $course->name,
            'is_course_admin' => $user->isCourseAdmin($course),
            'name'            => $this->name,
            'content'         => $this->content,
            'content_html'    => $this->content_html,
            'due_time'        => $this->due_time->setTimezone($user->timezone)->format('Y-m-d H:i:s'),
            'finished_at'     => $this->finishedAt($user),
            'rate_info'       => $this->ratedInfo(),
        ];
    }
}
