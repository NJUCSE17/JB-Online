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
        $downClass = "voteBtn text-dark";
        if ($problem->isLikedBy()) {
            $problem->unlikeBy();
            $upClass = "voteBtn text-dark";
        } else {
            $problem->likeBy();
            $upClass = "voteBtn text-success";
        }
        return json_encode([
            'status' => 1,
            'vote_up_class' => $upClass,
            'vote_down_class' => $downClass,
            'vote_count_label' => $problem->voteCountLabel,
        ]);
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
        $upClass = "voteBtn text-dark";
        if ($problem->isDislikedBy()) {
            $problem->undislikeBy();
            $downClass = "voteBtn text-dark";
        } else {
            $problem->dislikeBy();
            $downClass = "voteBtn text-danger";
        }
        return json_encode([
            'status' => 1,
            'vote_up_class' => $upClass,
            'vote_down_class' => $downClass,
            'vote_count_label' => $problem->voteCountLabel,
        ]);
    }
}
