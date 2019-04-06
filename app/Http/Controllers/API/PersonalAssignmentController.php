<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\PersonalAssignment\CreatePersonalAssignmentRequest;
use App\Http\Requests\PersonalAssignment\UpdatePersonalAssignmentRequest;
use App\Http\Requests\PersonalAssignment\ViewPersonalAssignmentRequest;
use App\Http\Requests\PersonalAssignment\DeletePersonalAssignmentRequest;
use App\Http\Requests\PersonalAssignment\FinishPersonalAssignmentRequest;
use App\Http\Requests\PersonalAssignment\ResetPersonalAssignmentRequest;
use App\Http\Resources\PersonalAssignmentResource;
use App\Http\Resources\PersonalAssignmentResourceCollection;
use App\Models\PersonalAssignment;
use Illuminate\Support\Facades\Auth;

class PersonalAssignmentController extends APIController
{
    /**
     * Create a new personal assignment.
     *
     * @param CreatePersonalAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreatePersonalAssignmentRequest $request)
    {
        $data = $request->only('name', 'content', 'due_time');
        $personal_assignment = PersonalAssignment::query()->create([
            'user_id'      => Auth::id(),
            'name'         => $data['name'],
            'content'      => $data['content'],
            'content_html' => $this->parser->text($data['content']),
            'due_time'     => $data['due_time'],
            'finished_at'  => null,
        ]);
        return $this->created(new PersonalAssignmentResource($personal_assignment));
    }

    /**
     * View personal assignments that satisfy constraints.
     * Default: current user, due in future.
     *
     * @param ViewPersonalAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(ViewPersonalAssignmentRequest $request)
    {
        if ($request->has('personal_assignment_id')) {
            $personal_assignment = PersonalAssignment::query()->findOrFail($request->get('personal_assignment_id'));
            return $this->data(new PersonalAssignmentResource($personal_assignment));
        } else {
            $personal_assignments = PersonalAssignment::query()->get()->where('user_id', Auth::id());
            if ($request->has('due_before')) {
                $personal_assignments = $personal_assignments->where('due_time', '<=', $request->get('due_before'));
            }
            $personal_assignments = $personal_assignments->where('due_time', '>=',
                $request->has('due_after') ? $request->get('due_after') : now());
            if ($request->has('unfinished_only') && $request->get('unfinished_only')) {
                $personal_assignments = $personal_assignments->where('finished_at', '=', null);
            }
            return $this->data(new PersonalAssignmentResourceCollection($personal_assignments));
        }
    }

    /**
     * Update a personal assignment.
     * 
     * @param UpdatePersonalAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePersonalAssignmentRequest $request)
    {
        $personal_assignment = PersonalAssignment::query()->findOrFail($request->get('personal_assignment_id'));
        $name     = $request->has('name')     ? $request->get('name')     : $personal_assignment->name;
        $content  = $request->has('content')  ? $request->get('content')  : $personal_assignment->content;
        $due_time = $request->has('due_time') ? $request->get('due_time') : $personal_assignment->due_time;
        $personal_assignment->update([
            'name'         => $name,
            'content'      => $content,
            'content_html' => $this->parser->text($content),
            'due_time'     => $due_time,
        ]);
        return $this->data(new PersonalAssignmentResource($personal_assignment));
    }

    /**
     * Delete a personal assignment.
     *
     * @param DeletePersonalAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(DeletePersonalAssignmentRequest $request)
    {
        PersonalAssignment::query()->findOrFail($request->get('personal_assignment_id'))->delete();
        return $this->data('Personal assignment deleted.');
    }

    /**
     * Finish a personal assignment.
     *
     * @param FinishPersonalAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function finish(FinishPersonalAssignmentRequest $request)
    {
        $personal_assignment = PersonalAssignment::query()->findOrFail($request->only('personal_assignment_id'));
        $personal_assignment->finished_at = now();
        return $this->data(new PersonalAssignmentResource($personal_assignment));
    }

    /**
     * Reset a personal assignment.
     *
     * @param ResetPersonalAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function reset(ResetPersonalAssignmentRequest $request)
    {
        $personal_assignment = PersonalAssignment::query()->findOrFail($request->only('personal_assignment_id'));
        $personal_assignment->finished_at = null;
        return $this->data('Personal assignment reset.');
    }
}
