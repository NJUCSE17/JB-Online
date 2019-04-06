<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\Assignment\CreateAssignmentRequest;
use App\Http\Requests\Assignment\DeleteAssignmentRequest;
use App\Http\Requests\Assignment\FinishAssignmentRequest;
use App\Http\Requests\Assignment\ResetAssignmentRequest;
use App\Http\Requests\Assignment\UpdateAssignmentRequest;
use App\Http\Requests\Assignment\ViewAssignmentRequest;
use App\Http\Resources\AssignmentFinishRecordResource;
use App\Http\Resources\AssignmentResource;
use App\Http\Resources\AssignmentResourceCollection;
use App\Models\Assignment;
use App\Models\AssignmentFinishRecord;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Assign;

class AssignmentController extends APIController
{
    /**
     * Create a new assignment.
     *
     * @param CreateAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateAssignmentRequest $request)
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
        if ($request->has('assignment_id')) {
            $assignment = Assignment::query()->findOrFail($request->get('assignment_id'));
            return $this->data(new AssignmentResource($assignment));
        } else {
            $assignments = Assignment::query()->get();
            if ($request->has('course_id')) {
                $assignments = $assignments->where('course_id', $request->get('course_id'));
            } else {
                // TODO: SUBSCRIBED BY USER (COURSE ENROLL)
            }
            if ($request->has('due_before')) {
                $assignments = $assignments->where('due_time', '<=', $request->get('due_before'));
            }
            $assignments = $assignments->where('due_time', '>=',
                $request->has('due_after') ? $request->get('due_after') : now());
            if ($request->has('unfinished_only') && $request->get('unfinished_only')) {
                $assignments = $assignments->where('finished_at', '=', null);
            }
            return $this->data(new AssignmentResourceCollection($assignments));
        }
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
        $record = AssignmentFinishRecord::query()->updateOrCreate([
            'user_id' => Auth::id(),
            'assignment_id' => $request->get('assignment_id'),
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
        AssignmentFinishRecord::query()
            ->where('user_id', Auth::id())
            ->where('assignment_id', $request->get('assignment_id'))
            ->delete();
        return $this->data('Assignment reset.');
    }
}
