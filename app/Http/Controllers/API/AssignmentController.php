<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\Assignment\DeleteAssignmentRequest;
use App\Http\Requests\Assignment\FinishAssignmentRequest;
use App\Http\Requests\Assignment\RateAssignmentRequest;
use App\Http\Requests\Assignment\ResetAssignmentRequest;
use App\Http\Requests\Assignment\ShowAssignmentRequest;
use App\Http\Requests\Assignment\StoreAssignmentRequest;
use App\Http\Requests\Assignment\UpdateAssignmentRequest;
use App\Http\Requests\Assignment\ViewAssignmentRequest;
use App\Http\Resources\AssignmentFinishRecordResource;
use App\Http\Resources\AssignmentResource;
use App\Http\Resources\AssignmentResourceCollection;
use App\Models\Assignment;
use App\Models\AssignmentFinishRecord;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends APIController
{
    /**
     * List specific assignments.
     * Default: course enrolled, due in future.
     *
     * @param  ViewAssignmentRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ViewAssignmentRequest $request)
    {
        $query = Assignment::query();
        if (!$request->has('show_all')) {
            if ($request->has('course_id')) {
                $query->where('course_id', $request->get('course_id'));
            } else {
                $query->whereIn('course_id', Auth::user()->courseIDs());
            }
        }

        if ($request->has('due_before')) {
            $query->where('due_time', '<=', $request->get('due_before'));
        }
        if ($request->has('due_after')) {
            $query->where('due_time', '>=', $request->get('due_after'));
        }

        if (!$request->has('show_all') && $request->has('unfinished_only')) {
            $assignment_ids = $query->pluck('id')->toArray();
            $finished_ids = AssignmentFinishRecord::query()
                ->where('user_id', Auth::id())
                ->whereIn('assignment_id', $assignment_ids)
                ->pluck('assignment_id')->toArray();
            $query->whereNotIn('id', $finished_ids);
        }

        return $this->data(new AssignmentResourceCollection($query->get()));
    }

    /**
     * Create a new assignment.
     *
     * @param  StoreAssignmentRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAssignmentRequest $request)
    {
        $data = $request->only('course_id', 'name', 'content', 'due_time');
        $assignment = Assignment::query()->create(
            [
                'course_id'    => $data['course_id'],
                'name'         => $data['name'],
                'content'      => $data['content'],
                'content_html' => $this->parser->text($data['content']),
                'due_time'     => $data['due_time'],
            ]
        );

        return $this->created(new AssignmentResource($assignment));
    }

    /**
     * Show a specific assignment.
     *
     * @param  ShowAssignmentRequest  $request
     * @param  Assignment             $assignment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ShowAssignmentRequest $request, Assignment $assignment)
    {
        return $this->data(new AssignmentResource($assignment));
    }

    /**
     * Update an assignment.
     *
     * @param  UpdateAssignmentRequest  $request
     * @param  Assignment               $assignment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        UpdateAssignmentRequest $request,
        Assignment $assignment
    ) {
        $name = $request->has('name') ? $request->get('name')
            : $assignment->name;
        $content = $request->has('content') ? $request->get('content')
            : $assignment->content;
        $due_time = $request->has('due_time') ? $request->get('due_time')
            : $assignment->due_time;
        $assignment->update(
            [
                'name'         => $name,
                'content'      => $content,
                'content_html' => $this->parser->text($content),
                'due_time'     => $due_time,
            ]
        );

        return $this->data(new AssignmentResource($assignment));
    }

    /**
     * Delete an assignment.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(
        DeleteAssignmentRequest $request,
        Assignment $assignment
    ) {
        $assignment->delete();

        return $this->data('Assignment deleted.');
    }

    /**
     * Finish an assignment.
     *
     * @param  FinishAssignmentRequest  $request
     * @param  Assignment               $assignment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function finish(
        FinishAssignmentRequest $request,
        Assignment $assignment
    ) {
        $record = AssignmentFinishRecord::query()->updateOrCreate(
            [
                'user_id'       => Auth::id(),
                'assignment_id' => $assignment->id,
            ]
        );

        return $this->data(new AssignmentFinishRecordResource($record));
    }

    /**
     * Reset an assignment.
     *
     * @param  ResetAssignmentRequest  $request
     * @param  Assignment              $assignment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(
        ResetAssignmentRequest $request,
        Assignment $assignment
    ) {
        AssignmentFinishRecord::query()
            ->where('user_id', Auth::id())
            ->where('assignment_id', $assignment->id)
            ->delete();

        return $this->data('Assignment reset.');
    }

    /**
     * Rate an assignment.
     *
     * @param  RateAssignmentRequest  $request
     * @param  Assignment              $assignment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function rate(
        RateAssignmentRequest $request,
        Assignment $assignment
    ) {
        $user = Auth::user();
        $rated = 'null';
        if ($request->get('like')) {
            if ($assignment->isDislikedBy($user)) {
                $assignment->undislikeBy($user);
            }
            if ($assignment->isLikedBy($user)) {
                $assignment->unlikeBy($user);
            } else {
                $assignment->likeBy($user);
                $rated = 'like';
            }
        } else {
            if ($assignment->isLikedBy($user)) {
                $assignment->unlikeBy($user);
            }
            if ($assignment->isDislikedBy($user)) {
                $assignment->undislikeBy($user);
            } else {
                $assignment->dislikeBy($user);
                $rated = 'dislike';
            }
        }

        return $this->data([
            'rated' => $rated,
            'stats' => [
                'like'    => $assignment->likesCount,
                'dislike' => $assignment->dislikesCount,
            ],
        ]);
    }
}
