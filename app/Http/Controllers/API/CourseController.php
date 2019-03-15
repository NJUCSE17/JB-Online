<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseResourceCollection;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends APIController
{
    public function create(StoreCourseRequest $request)
    {
        $data = $request->only(['name', 'semester', 'start_time', 'end_time', 'notice']);
        $course = Course::create([
            'name'        => $data['name'],
            'semester'    => $data['semester'],
            'start_time'  => $data['start_time'],
            'end_time'    => $data['end_time'],
            'notice'      => $data['notice'],
            'notice_html' => clean($this->parser->parse($data['notice'])),
        ]);
        return $this->data(new CourseResource($course));
    }

    // TODO: SELECT COURSES ACCORDING TO TIME
    // TODO: SELECT ASSIGNMENTS ACCORDING TO TIME
    /**
     * Get all courses.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return $this->data(new CourseResourceCollection(Course::all()));
    }

    /**
     * Get a course.
     *
     * @param $course_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($course_id)
    {
        $course = Course::find($course_id);
        if (!$course) {
            return $this->error('Course not found.', 404);
        } else {
            return $this->data(new CourseResource($course));
        }
    }

    /**
     * Update a course.
     *
     * @param Request $request
     * @param $course_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $course_id)
    {
        $course = Course::find($course_id);
        if (!$course) {
            return $this->error('Course not found.', 404);
        } else {
            $name       = $request->has('name')       ? $request->get('name')       : $course->name;
            $semester   = $request->has('semester')   ? $request->get('semester')   : $course->semester;
            $start_time = $request->has('start_time') ? $request->get('start_time') : $course->start_time;
            $end_time   = $request->has('end_time')   ? $request->get('end_time')   : $course->end_time;
            $notice     = $request->has('notice')     ? $request->get('notice')     : $course->notice;
            $course->update([
                'name'        => $name,
                'semester'    => $semester,
                'start_time'  => $start_time,
                'end_time'    => $end_time,
                'notice'      => $notice,
                'notice_html' => clean($this->parser->parse($notice)),
            ]);
            return $this->data(new CourseResource($course));
        }
    }

    /**
     * Delete a course.
     *
     * @param Request $request
     * @param $course_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $course_id)
    {
        $course = Course::find($course_id);
        if (!$course) {
            return $this->error('Course not found.', 404);
        } else {
            $course->delete();
            return $this->data('Course deleted.');
        }
    }
}
