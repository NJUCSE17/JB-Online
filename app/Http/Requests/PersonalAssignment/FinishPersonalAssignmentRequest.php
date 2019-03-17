<?php

namespace App\Http\Requests\PersonalAssignment;

use Illuminate\Foundation\Http\FormRequest;

class FinishPersonalAssignmentRequest extends FormRequest
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
            'user_id'                => ['required', 'int', 'exists:users,id'],
            'personal_assignment_id' => ['required', 'int', 'exists:personal_assignments,id'],
        ];
    }
}
