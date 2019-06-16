<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\PersonalAssignment\DeletePersonalAssignmentRequest;
use App\Http\Requests\PersonalAssignment\FinishPersonalAssignmentRequest;
use App\Http\Requests\PersonalAssignment\ResetPersonalAssignmentRequest;
use App\Http\Requests\PersonalAssignment\ShowPersonalAssignmentRequest;
use App\Http\Requests\PersonalAssignment\StorePersonalAssignmentRequest;
use App\Http\Requests\PersonalAssignment\UpdatePersonalAssignmentRequest;
use App\Http\Requests\PersonalAssignment\ViewPersonalAssignmentRequest;
use App\Http\Resources\PersonalAssignmentResource;
use App\Http\Resources\PersonalAssignmentResourceCollection;
use App\Models\PersonalAssignment;
use Illuminate\Support\Facades\Auth;

class PersonalAssignmentController extends APIController
{
    /**
     * View personal assignments.
     *
     * @param  ViewPersonalAssignmentRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ViewPersonalAssignmentRequest $request)
    {
        $query = $personal_assignments = PersonalAssignment::query();

        if (!$request->has('show_all')) {
            $query->where('user_id', $request->has('user_id')
                ? $request->get('user_id') : Auth::id());
        }

        if ($request->has('due_before')) {
            $query->where('due_time', '<=', $request->get('due_before'));
        }
        $query->where('due_time', '>=',
            $request->has('due_after') ? $request->get('due_after') : now()
        );
        if ($request->has('unfinished_only')
            && $request->get('unfinished_only')
        ) {
            $query->where('finished_at', '=', null);
        }


        return $this->data(
            new PersonalAssignmentResourceCollection($query->get())
        );
    }

    /**
     * Create a new personal assignment.
     *
     * @param  StorePersonalAssignmentRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePersonalAssignmentRequest $request)
    {
        $data = $request->only('name', 'content', 'due_time');
        $personal_assignment = PersonalAssignment::query()->create(
            [
                'user_id'      => Auth::id(),
                'name'         => $data['name'],
                'content'      => $data['content'],
                'content_html' => $this->parser->text($data['content']),
                'due_time'     => $data['due_time'],
                'finished_at'  => null,
            ]
        );

        return $this->created(
            new PersonalAssignmentResource($personal_assignment)
        );
    }

    /**
     * Show a specific personal assignment.
     *
     * @param  ShowPersonalAssignmentRequest  $request
     * @param  PersonalAssignment             $personalAssignment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(
        ShowPersonalAssignmentRequest $request,
        PersonalAssignment $personalAssignment
    ) {
        return $this->data(
            new PersonalAssignmentResource($personalAssignment)
        );
    }

    /**
     * Update a personal assignment.
     *
     * @param  UpdatePersonalAssignmentRequest  $request
     * @param  PersonalAssignment               $personalAssignment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        UpdatePersonalAssignmentRequest $request,
        PersonalAssignment $personalAssignment
    ) {
        $name = $request->has('name') ? $request->get('name')
            : $personalAssignment->name;
        $content = $request->has('content') ? $request->get('content')
            : $personalAssignment->content;
        $due_time = $request->has('due_time') ? $request->get('due_time')
            : $personalAssignment->due_time;
        $personalAssignment->update(
            [
                'name'         => $name,
                'content'      => $content,
                'content_html' => $this->parser->text($content),
                'due_time'     => $due_time,
            ]
        );

        return $this->data(
            new PersonalAssignmentResource($personalAssignment)
        );
    }

    /**
     * Delete a personal assignment.
     *
     * @param  DeletePersonalAssignmentRequest  $request
     * @param  PersonalAssignment               $personalAssignment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(
        DeletePersonalAssignmentRequest $request,
        PersonalAssignment $personalAssignment
    ) {
        $personalAssignment->delete();

        return $this->deleted();
    }

    /**
     * Finish a personal assignment.
     *
     * @param  FinishPersonalAssignmentRequest  $request
     * @param  PersonalAssignment               $personalAssignment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function finish(
        FinishPersonalAssignmentRequest $request,
        PersonalAssignment $personalAssignment
    ) {
        $personalAssignment->finished_at = now();
        $personalAssignment->save();

        return $this->data(
            new PersonalAssignmentResource($personalAssignment)
        );
    }

    /**
     * Reset a personal assignment.
     *
     * @param  ResetPersonalAssignmentRequest  $request
     * @param  PersonalAssignment              $personalAssignment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(
        ResetPersonalAssignmentRequest $request,
        PersonalAssignment $personalAssignment
    ) {
        $personalAssignment->finished_at = null;
        $personalAssignment->save();

        return $this->data('Personal assignment reset.');
    }
}
