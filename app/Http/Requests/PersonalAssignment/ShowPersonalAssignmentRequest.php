<?php

namespace App\Http\Requests\PersonalAssignment;

use Illuminate\Foundation\Http\FormRequest;

class ShowPersonalAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $personalAssignment = $this->route('personalAssignment');

        return $this->user()->can('show', $personalAssignment);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
