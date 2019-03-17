<?php

namespace App\Http\Requests\Problem;

use App\Rules\Sanitize;
use Illuminate\Foundation\Http\FormRequest;

class StoreProblemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // TODO: PERMISSION
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_id'     => ['required', 'int', 'exists:courses,id'],
            'assignment_id' => ['required', 'int', 'exists:assignments,id'],
            'content'       => ['required', new Sanitize(), 'max:200'],
        ];
    }
}
