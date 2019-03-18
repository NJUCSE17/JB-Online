<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\Assignment\FinishAssignmentRequest;
use App\Http\Requests\Assignment\ResetAssignmentRequest;
use App\Http\Requests\Assignment\StoreAssignmentRequest;
use App\Http\Requests\Assignment\UpdateAssignmentRequest;
use App\Http\Requests\Assignment\ViewAssignmentRequest;
use App\Http\Resources\AssignmentFinishRecordResource;
use App\Http\Resources\AssignmentResource;
use App\Http\Resources\AssignmentResourceCollection;
use App\Models\Assignment;
use App\Models\AssignmentFinishRecord;

class AssignmentController extends APIController
{
    /**
     * Create a new assignment.
     *
     * @param StoreAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(StoreAssignmentRequest $request)
    {
        $data = $request->only('course_id', 'name', 'content', 'due_time');
        $assignment = Assignment::query()->create([
            'course_id'    => $data['course_id'],
            'name'         => $data['name'],
            'content'      => $data['content'],
            'content_html' => $this->parser->text($data['content']),
            'due_time'     => $data['due_time'],
        ]);
        return $this->created(new AssignmentResource($assignment));
    }

    /**
     * View assignments that satisfy constraints.
     * Default: subscribed by user, due in future.
     *
     * @param ViewAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(ViewAssignmentRequest $request)
    {
        $query = Assignment::query(); // TODO: SUBSCRIBED BY USER (COURSE ENROLL)
        if ($request->has('course_id')) {
            $query->where('course_id', $request->get('course_id'));
        }
        if ($request->has('due_before')) {
            $query->where('due_time', '<=', $request->get('due_before'));
        }
        $query->where('due_time', '>=',
            $request->has('due_after') ? $request->get('due_after') : now());
        // TODO: FINISHED ASSIGNMENT ONLY (ASSIGNMENT FINISH)
        return $this->data(new AssignmentResourceCollection($query->get()));
    }

    /**
     * Get an assignment.
     *
     * @param $assignment_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($assignment_id)
    {
        $assignment = Assignment::query()->findOrFail($assignment_id);
        return $this->data(new AssignmentResource($assignment));
    }

    /**
     * Update an assignment.
     * 
     * @param UpdateAssignmentRequest $request
     * @param $assignment_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAssignmentRequest $request, $assignment_id)
    {
        $assignment = Assignment::query()->findOrFail($assignment_id);
        $name     = $request->has('name')     ? $request->get('name')     : $assignment->name;
        $content  = $request->has('content')  ? $request->get('content')  : $assignment->content;
        $due_time = $request->has('due_time') ? $request->get('due_time') : $assignment->due_time;
        $assignment->update([
            'name'         => $name,
            'content'      => $content,
            'content_html' => $this->parser->text($content),
            'due_time'     => $due_time,
        ]);
        return $this->data(new AssignmentResource($assignment));
    }

    /**
     * Delete an assignment.
     *
     * @param $assignment_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($assignment_id)
    {
        Assignment::query()->findOrFail($assignment_id)->delete();
        return $this->data('Assignment deleted.');
    }

    /**
     * Finish an assignment.
     *
     * @param FinishAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function finish(FinishAssignmentRequest $request)
    {
        $data = $request->only('user_id', 'assignment_id');
        $record = AssignmentFinishRecord::query()->updateOrCreate([
            'user_id'       => $data['user_id'],
            'assignment_id' => $data['assignment_id'],
        ]);
        return $this->data(new AssignmentFinishRecordResource($record));
    }

    /**
     * Reset an assignment.
     *
     * @param ResetAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function reset(ResetAssignmentRequest $request)
    {
        $data = $request->only('user_id', 'assignment_id');
        AssignmentFinishRecord::query()
            ->where('user_id', $data['user_id'])
            ->where('assignment_id', $data['assignment_id'])
            ->firstOrFail()
            ->delete();
        return $this->data('Assignment reset.');
    }
}
