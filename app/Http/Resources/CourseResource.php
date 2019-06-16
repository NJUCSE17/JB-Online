<?php

namespace App\Http\Resources;

use App\Models\Course;
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
        $user = $request->user();
        $course = Course::query()->find($this->id);
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'semester'    => $this->semester,
            'start_time'  => $this->start_time->format('Y-m-d H:i:s'),
            'end_time'    => $this->end_time->format('Y-m-d H:i:s'),
            'notice'      => $this->notice,
            'notice_html' => $this->notice_html,
            'is_in_course'    => $user->isInCourse($course),
            'is_course_admin' => $user->isCourseAdmin($course),
        ];
    }
}
