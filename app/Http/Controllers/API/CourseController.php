<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\Assignment\ViewAssignmentRequest;
use App\Http\Requests\Course\DeleteCourseRequest;
use App\Http\Requests\Course\EnrollCourseRequest;
use App\Http\Requests\Course\QuitCourseRequest;
use App\Http\Requests\Course\ShowCourseRequest;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Requests\Course\ViewCourseRequest;
use App\Http\Resources\CourseEnrollRecordResource;
use App\Http\Resources\CourseEnrollRecordResourceCollection;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseResourceCollection;
use App\Models\Course;
use App\Models\CourseEnrollRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CourseController extends APIController
{
    /**
     * View specific courses.
     *
     * @param  ViewAssignmentRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ViewAssignmentRequest $request)
    {
        $query = Course::query();
        if ($request->has('semester')) {
            $query->Semester($request->get('semester'));
        }
        if ($request->has('start_before')) {
            $query->Between(
                Carbon::parse($request->get('start_before'), Auth::user()->timezone)
                    ->setTimezone(config('app.timezone')),
                Carbon::parse($request->get('end_after'), Auth::user()->timezone)
                    ->setTimezone(config('app.timezone'))
            );
        }

        return $this->data(new CourseResourceCollection($query->get()));
    }

    /**
     * Create a course.
     *
     * @param  StoreCourseRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCourseRequest $request)
    {
        $data = $request->only(
            ['name', 'semester', 'start_time', 'end_time', 'notice']
        );
        $course = Course::query()->create(
            [
                'name'        => $data['name'],
                'semester'    => $data['semester'],
                'start_time'  => Carbon::parse($data['start_time'], Auth::user()->timezone)
                    ->setTimezone(config('app.timezone')),
                'end_time'    => Carbon::parse($data['end_time'], Auth::user()->timezone)
                    ->setTimezone(config('app.timezone')),
                'notice'      => $data['notice'],
                'notice_html' => clean($this->parser->parse($data['notice'])),
            ]
        );

        return $this->created(new CourseResource($course));
    }

    /**
     * Show a specific course.
     *
     * @param  ViewCourseRequest  $request
     * @param  Course             $course
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ViewCourseRequest $request, Course $course)
    {
        return $this->data(new CourseResource($course));
    }

    /**
     * Update a course.
     *
     * @param  UpdateCourseRequest  $request
     * @param  Course               $course
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $name = $request->has('name') ? $request->get('name') : $course->name;
        $semester = $request->has('semester') ? $request->get('semester')
            : $course->semester;
        $start_time = $request->has('start_time')
            ? Carbon::parse($request->get('start_time'), Auth::user()->timezone)
                ->setTimezone(config('app.timezone'))
            : $course->start_time;
        $end_time = $request->has('end_time')
            ? Carbon::parse($request->get('end_time'), Auth::user()->timezone)
                ->setTimezone(config('app.timezone'))
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
     * @param  Course               $course
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DeleteCourseRequest $request, Course $course)
    {
        $course->delete();

        return $this->deleted();
    }

    /**
     * Get enroll records of a course.
     *
     * @param  ShowCourseRequest  $request
     * @param  Course             $course
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function records(ShowCourseRequest $request, Course $course)
    {
        $records = $course->enrollRecords;

        return $this->data(new CourseEnrollRecordResourceCollection($records));
    }

    /**
     * Enroll a user to a course.
     *
     * @param  EnrollCourseRequest  $request
     * @param  Course               $course
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function enroll(EnrollCourseRequest $request, Course $course)
    {
        $record = CourseEnrollRecord::query()->updateOrCreate(
            [
                'user_id'       => $request->has('user_id')
                    ? $request->get('user_id') : Auth::id(),
                'course_id'     => $course->id,
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
     * @param  Course             $course
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function quit(QuitCourseRequest $request, Course $course)
    {
        CourseEnrollRecord::query()
            ->where('user_id', $request->has('user_id')
                ? $request->get('user_id') : Auth::id())
            ->where('course_id', $course->id)
            ->firstOrFail()
            ->delete();

        return $this->deleted();
    }
}
