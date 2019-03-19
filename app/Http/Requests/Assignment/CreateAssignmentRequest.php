<?php

namespace App\Http\Requests\Assignment;

use App\Models\Assignment;
use App\Models\Course;
use App\Rules\Sanitize;
use Illuminate\Foundation\Http\FormRequest;

class CreateAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $course = Course::query()->findOrFail($this->request->get('course_id'));
        return $this->user()->can('create', Assignment::class) || $this->user()->isCourseAdmin($course);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_id' => ['required', 'int', 'exists:courses,id'],
            'name' => ['required', new Sanitize(), 'max:100'],
            'content' => ['required', new Sanitize(), 'max:2000'],
            'due_time' => ['required', 'date_format:Y-m-d H:i:s'],
        ];
    }
}
