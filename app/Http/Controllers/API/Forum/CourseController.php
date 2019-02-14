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
     * @OA\Post(
     *     path="/api/course/{course_id}/check/student/{user_id}",
     *     tags={"Course"},
     *     summary="Check whether a user is a student of a course.",
     *     security={{"passport" : {}}},
     *     @OA\Parameter(
     *         name="course_id",
     *         description="Numeric ID of the course.",
     *         required=true,
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         description="Numeric ID of the user. (Empty for current user.)",
     *         required=false,
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/StudentAdminCheckResult"),
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @param Course $course
     * @param User|null $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkStudent(Request $request, Course $course, User $user = null) {
        if (!$user) $user = Auth::user();
        return response()->json([
            'result' => $course->checkEnrollment($user) == 1,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/course/{course_id}/check/admin/{user_id}",
     *     tags={"Course"},
     *     summary="Check whether a user is an admin of a course.",
     *     security={{"passport" : {}}},
     *     @OA\Parameter(
     *         name="course_id",
     *         description="Numeric ID of the course.",
     *         required=true,
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         description="Numeric ID of the user. (Empty for current user.)",
     *         required=false,
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/StudentAdminCheckResult"),
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @param Course $course
     * @param User|null $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAdmin(Request $request, Course $course, User $user = null) {
        if (!$user) $user = Auth::user();
        return response()->json([
            'result' => $course->checkEnrollment($user) == 2,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/course/{course_id}/add/student/{user_id}",
     *     tags={"Course"},
     *     summary="Add a user to a course as student.",
     *     security={{"passport" : {}}},
     *     @OA\Parameter(
     *         name="course_id",
     *         description="Numeric ID of the course.",
     *         required=true,
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         description="Numeric ID of the user. (ONLY ADMIN CAN FILL THIS)",
     *         required=false,
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/StudentAdminAddDeleteResult"),
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @param Course $course
     * @param User|null $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function addStudent(Request $request, Course $course, User $user = null) {
        $currentUser = Auth::user();
        if (!$user) $user = $currentUser;
        if ($user !== $currentUser
            && !($currentUser->isExecutive() || $currentUser->isAdmin())) {
            return response()->json([
                'message' => 'Not authorized.',
            ], 401);
        }

        $course->addStudent($user);
        return response()->json([
            'message' => 'Successfully added ' . $user->name . ' as a student of ' . $course->name,
            'button_html' => $course->getCourseEnrollButtonAttribute($user),
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/course/{course_id}/add/admin/{user_id}",
     *     tags={"Course"},
     *     summary="Add a user to a course as admin. (ADMIN ONLY)",
     *     security={{"passport" : {}}},
     *     @OA\Parameter(
     *         name="course_id",
     *         description="Numeric ID of the course.",
     *         required=true,
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         description="Numeric ID of the user.",
     *         required=false,
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/StudentAdminAddDeleteResult"),
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @param Course $course
     * @param User|null $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAdmin(Request $request, Course $course, User $user = null) {
        $currentUser = Auth::user();
        if (!$user) $user = $currentUser;
        if ($user !== $currentUser
            && !($currentUser->isExecutive() || $currentUser->isAdmin())) {
            return response()->json([
                'message' => 'Not authorized.',
            ], 401);
        }

        $course->addAdmin($user);
        return response()->json([
            'message' => 'Successfully added ' . $user->name . ' as an admin of ' . $course->name,
            'button_html' => $course->getCourseEnrollButtonAttribute($user),
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/course/{course_id}/delete/user/{user_id}",
     *     tags={"Course"},
     *     summary="Remove a user from a course.",
     *     security={{"passport" : {}}},
     *     @OA\Parameter(
     *         name="course_id",
     *         description="Numeric ID of the course.",
     *         required=true,
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         description="Numeric ID of the user. (ONLY ADMIN CAN FILL THIS)",
     *         required=false,
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/StudentAdminAddDeleteResult"),
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @param Course $course
     * @param User|null $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser(Request $request, Course $course, User $user = null) {
        $currentUser = Auth::user();
        if (!$user) $user = $currentUser;
        if ($user !== $currentUser
            && !($currentUser->isExecutive() || $currentUser->isAdmin())) {
            return response()->json([
                'message' => 'Not authorized.',
            ], 401);
        }

        $course->deleteUser($user);
        return response()->json([
            'message' => 'Successfully deleted ' . $user->name . ' from course ' . $course->name,
            'button_html' => $course->getCourseEnrollButtonAttribute($user),
        ], 200);
    }
}

/**
 * @OA\Schema()
 */
class StudentAdminCheckResult
{
    /**
     * Query result.
     *
     * @var boolean
     * @OA\Property()
     */
    public $result;
}

/**
 * @OA\Schema()
 */
class StudentAdminAddDeleteResult
{
    /**
     * Result message
     *
     * @var string
     * @OA\Property()
     */
    public $message;

    /**
     * Updated course button
     *
     * @var string
     * @OA\Property()
     */
    public $button_html;
}