<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\Assignment\StorePersonalAssignmentRequest;
use App\Http\Requests\Assignment\UpdatePersonalAssignmentRequest;
use App\Http\Requests\Assignment\ViewPersonalAssignmentRequest;
use App\Http\Requests\PersonalAssignment\FinishPersonalAssignmentRequest;
use App\Http\Requests\PersonalAssignment\ResetPersonalAssignmentRequest;
use App\Http\Resources\PersonalAssignmentResource;
use App\Http\Resources\PersonalAssignmentResourceCollection;
use App\Models\PersonalAssignment;
use App\Models\PersonalAssignmentFinishRecord;
use Illuminate\Support\Facades\Auth;

class PersonalAssignmentController extends APIController
{
    /**
     * Create a new personal assignment.
     *
     * @param StorePersonalAssignmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(StorePersonalAssignmentRequest $request)
    {
        $data = $request->only('user_id', 'name', 'content', 'due_time');
        $personal_assignment = PersonalAssignment::query()->create([
            'user_id'      => $data['user_id'],
            'name'         => $data['name'],
            'content'      => $data['content'],
            'content_html' => $this->parser->text($data['content']),
            'due_time'     => $data['due_time'],
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
        $query = PersonalAssignment::query();
        $query->where('user_id', $request->has('user_id') ? $request->get('user_id') : Auth::id());
        if ($request->has('due_before')) {
            $query->where('due_time', '<=', $request->get('due_before'));
        }
        $query->where('due_time', '>=',
            $request->has('due_after') ? $request->get('due_after') : now());
        // TODO: FINISHED ASSIGNMENT ONLY (ASSIGNMENT FINISH)
        return $this->data(new PersonalAssignmentResourceCollection($query->get()));
    }

    /**
     * Get a personal assignment.
     *
     * @param $personal_assignment_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($personal_assignment_id)
    {
        $personal_assignment = PersonalAssignment::query()->findOrFail($personal_assignment_id);
        return $this->data(new PersonalAssignmentResource($personal_assignment));
    }

    /**
     * Update a personal assignment.
     * 
     * @param UpdatePersonalAssignmentRequest $request
     * @param $personal_assignment_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePersonalAssignmentRequest $request, $personal_assignment_id)
    {
        $personal_assignment = PersonalAssignment::query()->findOrFail($personal_assignment_id);
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
     * @param $personal_assignment_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($personal_assignment_id)
    {
        PersonalAssignment::query()->findOrFail($personal_assignment_id)->delete();
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
        $data = $request->only('user_id', 'personal_assignment_id');
        $record = PersonalAssignment::query()->updateOrCreate([
            'user_id'                => $data['user_id'],
            'personal_assignment_id' => $data['assignment_id'],
        ]);
        return $this->data(new PersonalAssignmentResource($record));
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
        $data = $request->only('user_id', 'personal_assignment_id');
        PersonalAssignmentFinishRecord::query()
            ->where('user_id', $data['user_id'])
            ->where('personal_assignment_id', $data['personal_assignment_id'])
            ->firstOrFail()
            ->delete();
        return $this->data('Personal assignment reset.');
    }
}
