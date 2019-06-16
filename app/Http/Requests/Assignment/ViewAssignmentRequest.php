<?php

namespace App\Http\Requests\Assignment;

use App\Models\Assignment;
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
        return $this->user()->can('view', Assignment::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'show_all'        => ['sometimes', 'required', 'boolean'],
            'course_id'       => [
                'sometimes',
                'required',
                'integer',
                'exists:courses,id',
            ],
            'due_after'       => [
                'sometimes',
                'required',
                'date_format:Y-m-d H:i:s',
            ],
            'due_before'      => [
                'sometimes',
                'required',
                'date_format:Y-m-d H:i:s',
            ],
            'unfinished_only' => ['sometimes', 'required', 'boolean'],
        ];
    }
}
