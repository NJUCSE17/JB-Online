<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\Problem\StoreProblemRequest;
use App\Http\Requests\Problem\DeleteProblemRequest;
use App\Http\Requests\Problem\ShowProblemRequest;
use App\Http\Requests\Problem\UpdateProblemRequest;
use App\Http\Requests\Problem\ViewProblemRequest;
use App\Http\Resources\ProblemResource;
use App\Http\Resources\ProblemResourceCollection;
use App\Models\Problem;

class ProblemController extends APIController
{
    /**
     * View problems.
     *
     * @param  ViewProblemRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ViewProblemRequest $request)
    {
        $query = Problem::query();
        if ($request->has('assignment_id')) {
            $query->where('assignment_id', $request->get('assignment_id'));
        }
        if ($request->has('course_id')) {
            $query->where('course_id', $request->get('course_id'));
        }

        return $this->data(new ProblemResourceCollection($query->get()));
    }

    /**
     * Create a problem.
     *
     * @param  StoreProblemRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store (StoreProblemRequest $request)
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
     * Show a problem.
     *
     * @param  ShowProblemRequest  $request
     * @param  Problem             $problem
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ShowProblemRequest $request, Problem $problem)
    {
        return $this->data(new ProblemResource($problem));
    }

    /**
     * Update a problem.
     *
     * @param  UpdateProblemRequest  $request
     * @param  Problem               $problem
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProblemRequest $request, Problem $problem)
    {
        $problem->update(['content' => $request->get('content')]);

        return $this->data(new ProblemResource($problem));
    }

    /**
     * Delete a problem.
     *
     * @param  DeleteProblemRequest  $request
     * @param  Problem               $problem
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DeleteProblemRequest $request, Problem $problem)
    {
        $problem->delete();

        return $this->data('Problem deleted.');
    }
}
