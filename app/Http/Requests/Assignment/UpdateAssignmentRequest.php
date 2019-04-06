<?php

namespace App\Http\Requests\Assignment;

use App\Models\Assignment;
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
        $assignment = Assignment::query()->findOrFail(
            $this->request->get('assignment_id')
        );

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
            'assignment_id' => ['required', 'integer', 'exists:assignments,id'],
            'name'          => [
                'sometimes',
                'required',
                new Sanitize(),
                'max:100',
            ],
            'content'       => [
                'sometimes',
                'required',
                new Sanitize(),
                'max:2000',
            ],
            'due_time'      => [
                'sometimes',
                'required',
                'date_format:Y-m-d H:i:s',
            ],
        ];
    }
}
