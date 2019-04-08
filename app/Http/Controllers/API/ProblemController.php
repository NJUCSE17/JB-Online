<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\Problem\CreateProblemRequest;
use App\Http\Requests\Problem\DeleteProblemRequest;
use App\Http\Requests\Problem\UpdateProblemRequest;
use App\Http\Requests\Problem\ViewProblemRequest;
use App\Http\Resources\ProblemResource;
use App\Http\Resources\ProblemResourceCollection;
use App\Models\Problem;

class ProblemController extends APIController
{
    /**
     * Create a problem.
     *
     * @param  CreateProblemRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateProblemRequest $request)
    {
        $data = $request->only('course_id', 'assignment_id', 'content');
        $problem = Problem::query()->create(
            [
                'course_id'     => $data['course_id'],
                'assignment_id' => $data['assignment_id'],
                'content'       => $data['content'],
            ]
        );

        return $this->created(new ProblemResource($problem));
    }

    /**
     * View problems of a course or an assignment.
     *
     * @param  ViewProblemRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(ViewProblemRequest $request)
    {
        if ($request->has('problem_id')) {
            $problem = Problem::query()
                ->findOrFail($request->get('problem_id'));

            return $this->data(new ProblemResource($problem));
        } else {
            $problems = Problem::query()
                ->where('assignment_id', $request->get('assignment_id'))
                ->get();

            return $this->data(new ProblemResourceCollection($problems));
        }
    }

    /**
     * Update a problem.
     *
     * @param  UpdateProblemRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProblemRequest $request)
    {
        $problem = Problem::query()->findOrFail($request->get('problem_id'));
        $problem->update(['content' => $request->get('content')]);

        return $this->data(new ProblemResource($problem));
    }

    /**
     * Delete a problem.
     *
     * @param  DeleteProblemRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(DeleteProblemRequest $request)
    {
        Problem::query()->findOrFail($request->get('problem_id'))->delete();

        return $this->data('Problem deleted.');
    }
}
