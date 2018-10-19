<?php

namespace App\Http\Controllers\Frontend\Forum;

use App\Jobs\SendReplyMail;
use App\Models\Auth\User;
use App\Models\Forum\Problem;
use App\Models\Forum\Course;
use App\Models\Forum\Assignment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProblemController.
 */
class ProblemController extends Controller
{
    /**
     * @var Course
     * @var Assignment
     * @var Problem
     * @return mixed
     */
    public function voteUp(Course $course, Assignment $assignment, Problem $problem)
    {
        if ($problem->isDislikedBy()) {
            $problem->undislikeBy();
        }
        if ($problem->isLikedBy()) {
            $problem->unlikeBy();
        } else {
            $problem->likeBy();
        }
        return redirect()->back();
    }

    /**
     * @var Course
     * @var Assignment
     * @var Problem
     * @return mixed
     */
    public function voteDown(Course $course, Assignment $assignment, Problem $problem)
    {
        if ($problem->isLikedBy()) {
            $problem->unlikeBy();
        }
        if ($problem->isDislikedBy()) {
            $problem->undislikeBy();
        } else {
            $problem->dislikeBy();
        }
        return redirect()->back();
    }
}
