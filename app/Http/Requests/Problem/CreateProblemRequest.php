<?php

namespace App\Http\Requests\Problem;

use App\Models\Course;
use App\Models\Problem;
use App\Rules\Sanitize;
use Illuminate\Foundation\Http\FormRequest;

class CreateProblemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $course = Course::query()->findOrFail($this->request->get('course_id'));

        return $this->user()->isCourseAdmin($course)
            || $this->user()->can('create', Problem::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'assignment_id' => ['required', 'integer', 'exists:assignments,id'],
            'content' => ['required', new Sanitize(), 'max:200'],
        ];
    }
}
