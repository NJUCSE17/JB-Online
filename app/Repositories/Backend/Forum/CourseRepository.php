<?php

namespace App\Repositories\Backend\Forum;

use App\Models\Forum\Course;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use App\Events\Backend\Forum\Course\CourseCreated;
use App\Events\Backend\Forum\Course\CourseUpdated;
use App\Events\Backend\Forum\Course\CourseRestored;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Events\Backend\Forum\Course\CoursePermanentlyDeleted;

/**
 * Class CourseRepository.
 */
class CourseRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Course::class;
    }

    /**
     * @return mixed
     */
    public function getCount() : int
    {
        return $this->model
            ->count();
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getDeletedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
            ->onlyTrashed()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     *
     * @return mixed
     */
    public function getCoursePlucked()
    {
        return $this->model
            ->orderBy('id', 'dec')
            ->get()
            ->pluck('name', 'id');
    }

    /**
     * @param array $data
     *
     * @return Course
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data) : Course
    {
        return DB::transaction(function () use ($data) {
            $course = parent::create([
                'name' => $data['name'],
                'semester' => $data['semester'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'notice' => $data['notice'],
                'difficulty' => $data['difficulty'],
                'restrict_level' => $data['restrict_level'],
                'user_id' => $data['user_id'],
            ]);

            if ($course) {
                event(new CourseCreated($course));
                return $course;
            }

            throw new GeneralException(__('exceptions.backend.access.courses.create_error'));
        });
    }

    /**
     * @param Course  $course
     * @param array $data
     *
     * @return Course
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function update(Course $course, array $data) : Course
    {
        return DB::transaction(function () use ($course, $data) {
            if ($course->update([
                'name' => $data['name'],
                'semester' => $data['semester'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'notice' => $data['notice'],
                'difficulty' => $data['difficulty'],
                'restrict_level' => $data['restrict_level'],
                'user_id' => $data['user_id'],
            ])) {
                event(new CourseUpdated($course));
                return $course;
            }

            throw new GeneralException(__('exceptions.backend.access.courses.update_error'));
        });
    }

    /**
     * @param Course $course
     *
     * @return Course
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function forceDelete(Course $course) : Course
    {
        if (is_null($course->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.courses.delete_first'));
        }

        return DB::transaction(function () use ($course) {
            if ($course->forceDelete()) {
                event(new CoursePermanentlyDeleted($course));
                return $course;
            }

            throw new GeneralException(__('exceptions.backend.access.courses.delete_error'));
        });
    }

    /**
     * @param Course $course
     *
     * @return Course
     * @throws GeneralException
     */
    public function restore(Course $course) : Course
    {
        if (is_null($course->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.courses.cant_restore'));
        }

        if ($course->restore()) {
            event(new CourseRestored($course));
            return $course;
        }

        throw new GeneralException(__('exceptions.backend.access.courses.restore_error'));
    }
}
