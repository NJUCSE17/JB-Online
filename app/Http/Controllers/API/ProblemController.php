<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\Problem\StoreProblemRequest;
use App\Http\Requests\Problem\UpdateProblemRequest;
use App\Http\Requests\Problem\ViewProblemRequest;
use App\Http\Resources\ProblemResource;
use App\Http\Resources\ProblemResourceCollection;
use App\Models\Problem;

class ProblemController extends APIController
{
    public function create(StoreProblemRequest $request)
    {
        $data = $request->only('course_id', 'assignment_id', 'content');
        $problem = Problem::query()->create([
            'course_id'     => $data['course_id'],
            'assignment_id' => $data['assignment_id'],
            'content'       => $data['content'],
        ]);
        return $this->data(new ProblemResource($problem));
    }

    public function view(ViewProblemRequest $request)
    {
        $query = Problem::query();
        if ($request->has('course_id')) {
            $query->where('course_id', $request->get('course_id'))->get();
        }
        if ($request->has('assignment_id')) {
            $query->where('assignment_id', $request->get('assignment_id'))->get();
        }
        return $this->data(new ProblemResourceCollection($query->get()));
    }

    public function get($problem_id)
    {
        $problem = Problem::query()->findOrFail($problem_id);
        return $this->data(new ProblemResource($problem));
    }

    public function update(UpdateProblemRequest $request, $problem_id)
    {
        $problem = Problem::query()->findOrFail($problem_id);
        $problem->update(['content' => $request->get('content')]);
        return $this->data(new ProblemResource($problem));
    }

    public function delete($problem_id)
    {
        Problem::query()->findOrFail($problem_id)->delete();
        return $this->data('Problem deleted.');
    }
}
