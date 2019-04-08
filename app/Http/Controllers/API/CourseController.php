<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Requests\Course\DeleteCourseRequest;
use App\Http\Requests\Course\EnrollCourseRequest;
use App\Http\Requests\Course\QuitCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Requests\Course\ViewCourseRequest;
use App\Http\Resources\CourseEnrollRecordResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseResourceCollection;
use App\Models\Course;
use App\Models\CourseEnrollRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CourseController extends APIController
{
    /**
     * Create a course.
     *
     * @param  CreateCourseRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateCourseRequest $request)
    {
        $data = $request->only(
            ['name', 'semester', 'start_time', 'end_time', 'notice']
        );
        $course = Course::query()->create(
            [
                'name'        => $data['name'],
                'semester'    => $data['semester'],
                'start_time'  => $data['start_time'],
                'end_time'    => $data['end_time'],
                'notice'      => $data['notice'],
                'notice_html' => clean($this->parser->parse($data['notice'])),
            ]
        );

        return $this->created(new CourseResource($course));
    }

    /**
     * View all courses satisfying the constraints.
     *
     * @param  ViewCourseRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(ViewCourseRequest $request)
    {
        if ($request->has('course_id')) {
            $course = Course::query()->findOrFail($request->get('course_id'));

            return $this->data(new CourseResource($course));
        } else {
            $query = Course::query();
            if ($request->has('semester')) {
                $query->Semester($request->get('semester'));
            }
            if ($request->has('start_before')) {
                $query->Between(
                    Carbon::parse($request->get('start_before')),
                    Carbon::parse($request->get('end_after'))
                );
            }

            return $this->data(new CourseResourceCollection($query->get()));
        }
    }

    /**
     * Update a course.
     *
     * @param  UpdateCourseRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCourseRequest $request)
    {
        $course = Course::query()->findOrFail($request->get('course_id'));
        $name = $request->has('name') ? $request->get('name') : $course->name;
        $semester = $request->has('semester') ? $request->get('semester')
            : $course->semester;
        $start_time = $request->has('start_time') ? $request->get('start_time')
            : $course->start_time;
        $end_time = $request->has('end_time') ? $request->get('end_time')
            : $course->end_time;
        $notice = $request->has('notice') ? $request->get('notice')
            : $course->notice;
        $course->update(
            [
                'name'        => $name,
                'semester'    => $semester,
                'start_time'  => $start_time,
                'end_time'    => $end_time,
                'notice'      => $notice,
                'notice_html' => clean($this->parser->parse($notice)),
            ]
        );

        return $this->data(new CourseResource($course));
    }

    /**
     * Delete a course.
     *
     * @param  DeleteCourseRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(DeleteCourseRequest $request)
    {
        Course::query()->findOrFail($request->get('course_id'))->delete();

        return $this->data('Course deleted.');
    }

    /**
     * Enroll a user to a course.
     *
     * @param  EnrollCourseRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function enroll(EnrollCourseRequest $request)
    {
        $record = CourseEnrollRecord::query()->updateOrCreate(
            [
                'user_id'       => $request->has('user_id')
                    ? $request->get('user_id') : Auth::id(),
                'course_id'     => $request->get('course_id'),
                'type_is_admin' => $request->has('type_is_admin')
                    ? $request->get('type_is_admin') : false,
            ]
        );

        return $this->data(new CourseEnrollRecordResource($record));
    }

    /**
     * Quit a user from a course.
     *
     * @param  QuitCourseRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function quit(QuitCourseRequest $request)
    {
        CourseEnrollRecord::query()
            ->where('user_id', $request->has('user_id')
                ? $request->get('user_id') : Auth::id())
            ->where('course_id', $request->get('course_id'))
            ->firstOrFail()
            ->delete();

        return $this->data('Course quited.');
    }
}
