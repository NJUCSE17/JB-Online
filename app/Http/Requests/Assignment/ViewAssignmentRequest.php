<?php

namespace App\Http\Requests\Assignment;

use Illuminate\Foundation\Http\FormRequest;

class ViewAssignmentRequest extends FormRequest
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
            'course_id'  => ['sometimes', 'int', 'exists:courses,id'],
            'due_after'  => ['sometimes', 'date_format:Y-m-d H:i:s'],
            'due_before' => ['sometimes', 'date_format:Y-m-d H:i:s'],
            'unfinished_only' => ['sometimes', 'boolean'],
        ];
    }
}
