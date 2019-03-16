<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\Course\GetCourseRequest;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Requests\Course\ViewCourseRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseResourceCollection;
use App\Models\Course;
use Carbon\Carbon;

class CourseController extends APIController
{
    /**
     * Create a course.
     *
     * @param StoreCourseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * View all courses satisfying the constraints.
     *
     * @param ViewCourseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(ViewCourseRequest $request)
    {
        $query = Course::query();
        if ($request->has('semester')) {
            $query->Semester($request->get('semester'));
        }
        if ($request->has('start_before')) {
            $query->Between(Carbon::parse($request->get('start_before')),
                Carbon::parse($request->get('end_after')));
        }
        return $this->data(new CourseResourceCollection($query->get()));
    }

    /**
     * Get a course.
     *
     * @param GetCourseRequest $request
     * @param $course_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(GetCourseRequest $request, $course_id)
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
     * @param UpdateCourseRequest $request
     * @param $course_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCourseRequest $request, $course_id)
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
     * @param $course_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($course_id)
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
