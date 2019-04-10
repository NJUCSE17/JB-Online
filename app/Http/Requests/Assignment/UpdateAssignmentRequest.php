<?php

namespace App\Http\Requests\Assignment;

use App\Rules\Sanitize;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $assignment = $this->route('assignment');

        return $this->user()->can('update', $assignment);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => [
                'sometimes',
                'required',
                new Sanitize(),
                'max:100',
            ],
            'content'  => [
                'sometimes',
                'required',
                new Sanitize(),
                'max:2000',
            ],
            'due_time' => [
                'sometimes',
                'required',
                'date_format:Y-m-d H:i:s',
            ],
        ];
    }
}
