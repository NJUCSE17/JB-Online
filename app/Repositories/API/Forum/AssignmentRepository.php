<?php

namespace App\Repositories\API\Forum;

use App\Models\Forum\Assignment;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class AssignmentRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Assignment::class;
    }

    /**
     * Get assignments for API.
     * Only ID, courseID, name, content, due_time and issuer will be selected.
     * A boolean finished mark will be added to each assignment.
     *
     * @return Assignment array
     */
    public function getOngoingAssignments()
    {
        $assignments = $this->model
            ->where('due_time', '>', date("Y-m-d H:i:s"))
            ->subscribedByUser(Auth::id())
            ->orderBy('due_time')
            ->get([
                'assignments.id',
                'assignments.course_id',
                'assignments.name',
                'assignments.content_html',
                'assignments.due_time',
                'assignments.issuer'
            ]);
        foreach ($assignments as $assignment) {
            $assignment['finished'] = $assignment->is_finished;
            $assignment['course_name'] = $assignment->course_name;
        }
        return $assignments;
    }
}