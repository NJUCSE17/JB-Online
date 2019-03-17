<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\Assignment\StorePersonalAssignmentRequest;
use App\Http\Requests\Assignment\UpdatePersonalAssignmentRequest;
use App\Http\Requests\Assignment\ViewPersonalAssignmentRequest;
use App\Http\Resources\AssignmentResource;
use App\Http\Resources\AssignmentResourceCollection;
use App\Models\Assignment;

class AssignmentController extends APIController
{
    /**
     * Create a new assignment.
     *
     * @param StorePersonalAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(StorePersonalAssignmentRequest $request)
    {
        $data = $request->only('course_id', 'name', 'content', 'due_time');
        $assignment = Assignment::query()->create([
            'course_id'    => $data['course_id'],
            'name'         => $data['name'],
            'content'      => $data['content'],
            'content_html' => $this->parser->text($data['content']),
            'due_time'     => $data['due_time'],
        ]);
        return $this->data(new AssignmentResource($assignment));
    }

    /**
     * View assignments that satisfy constraints.
     * Default: subscribed by user, due in future.
     *
     * @param ViewPersonalAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(ViewPersonalAssignmentRequest $request)
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
     * @param UpdatePersonalAssignmentRequest $request
     * @param $assignment_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePersonalAssignmentRequest $request, $assignment_id)
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
}
