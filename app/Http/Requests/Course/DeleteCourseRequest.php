<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // TODO: PERMISSIONS
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
        ];
    }
}
