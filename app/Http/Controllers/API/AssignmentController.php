<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\Assignment\DeleteAssignmentRequest;
use App\Http\Requests\Assignment\FinishAssignmentRequest;
use App\Http\Requests\Assignment\ResetAssignmentRequest;
use App\Http\Requests\Assignment\StoreAssignmentRequest;
use App\Http\Requests\Assignment\UpdateAssignmentRequest;
use App\Http\Requests\Assignment\ReadAssignmentRequest;
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
     * Read(Get) assignments that satisfy constraints.
     * Default: subscribed by user, due in future.
     *
     * @param ReadAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function read(ReadAssignmentRequest $request)
    {
        $query = Assignment::query();
        if ($request->has('assignment_id')) {
            $query->findOrFail('assignment_id');
        } else {
            if ($request->has('course_id')) {
                $query->where('course_id', $request->get('course_id'));
            } else {
                // TODO: SUBSCRIBED BY USER (COURSE ENROLL)
            }
            if ($request->has('due_before')) {
                $query->where('due_time', '<=', $request->get('due_before'));
            }
            $query->where('due_time', '>=',
                $request->has('due_after') ? $request->get('due_after') : now());
            // TODO: FINISHED ASSIGNMENT ONLY (ASSIGNMENT FINISH)
        }
        return $this->data(new AssignmentResourceCollection($query->get()));
    }

    /**
     * Update an assignment.
     * 
     * @param UpdateAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAssignmentRequest $request)
    {
        $assignment = Assignment::query()->findOrFail($request->get('assignment_id'));
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(DeleteAssignmentRequest $request)
    {
        Assignment::query()->findOrFail($request->get('assignment_id'))->delete();
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
