<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\Problem\DeleteProblemRequest;
use App\Http\Requests\Problem\StoreProblemRequest;
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
     * @param  StoreProblemRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(StoreProblemRequest $request)
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
        $query = Problem::query();
        if ($request->has('problem_id')) {
            $query->findOrFail($request->get('problem_id'));
        } else {
            if ($request->has('course_id')) {
                $query->where('course_id', $request->get('course_id'))->get();
            }
            if ($request->has('assignment_id')) {
                $query->where('assignment_id', $request->get('assignment_id'))
                    ->get();
            }
        }

        return $this->data(new ProblemResourceCollection($query->get()));
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
