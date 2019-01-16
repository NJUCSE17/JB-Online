<?php

namespace App\Http\Controllers\API\Forum;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Forum\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class CourseController extends Controller
{
    /**
     * Check whether a user belongs to a course as a student.
     *
     * @param Request $request
     * @param Course $course
     * @param User|null $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkStudent(Request $request, Course $course, User $user = null) {
        if (!$user) $user = Auth::user();
        return response()->json([
            'message' => 'Query success.',
            'result' => $course->checkEnrollment($user) == 1,
        ], 200);
    }

    /**
     * Check whether a user belongs to a course as an admin.
     *
     * @param Request $request
     * @param Course $course
     * @param User|null $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAdmin(Request $request, Course $course, User $user = null) {
        if (!$user) $user = Auth::user();
        return response()->json([
            'message' => 'Query success.',
            'result' => $course->checkEnrollment($user) == 2,
        ], 200);
    }

    /**
     * Add a user as a student to a course.
     *
     * @param Request $request
     * @param Course $course
     * @param User|null $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function addStudent(Request $request, Course $course, User $user = null) {
        $currentUser = Auth::user();
        if (!$currentUser->isAdmin() && $user !== $currentUser) {
            return response()->json([
                'message' => 'Not authorized.',
            ], 401);
        }
        if (!$user) $user = $currentUser;

        $course->addStudent($user);
        return response()->json([
            'message' => 'Successfully added ' . $user->name . ' as a student of ' . $course->name,
            'button_html' => $course->getCourseEnrollButtonAttribute($user),
        ], 200);
    }

    /**
     * Add a user as an admin to a course.
     *
     * @param Request $request
     * @param Course $course
     * @param User|null $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAdmin(Request $request, Course $course, User $user = null) {
        $currentUser = Auth::user();
        if (!$currentUser->isAdmin() && $user !== $currentUser) {
            return response()->json([
                'message' => 'Not authorized.',
            ], 401);
        }
        if (!$user) $user = $currentUser;

        $course->addAdmin($user);
        return response()->json([
            'message' => 'Successfully added ' . $user->name . ' as an admin of ' . $course->name,
            'button_html' => $course->getCourseEnrollButtonAttribute($user),
        ], 200);
    }

    /**
     * Delete a user from a course.
     *
     * @param Request $request
     * @param Course $course
     * @param User|null $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser(Request $request, Course $course, User $user = null) {
        $currentUser = Auth::user();
        if (!$currentUser->isAdmin() && $user !== $currentUser) {
            return response()->json([
                'message' => 'Not authorized.',
            ], 401);
        }
        if (!$user) $user = $currentUser;

        $course->deleteUser($user);
        return response()->json([
            'message' => 'Successfully deleted ' . $user->name . ' from course ' . $course->name,
            'button_html' => $course->getCourseEnrollButtonAttribute($user),
        ], 200);
    }
}