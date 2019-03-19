<?php

namespace App\Http\Requests\PersonalAssignment;

use Illuminate\Foundation\Http\FormRequest;

class DeletePersonalAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;  // TODO: PERMISSIONS
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'personal_assignment_id' => ['required', 'int', 'exists:personal_assignments,id'],
        ];
    }
}
