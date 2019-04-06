<?php

namespace App\Http\Requests\PersonalAssignment;

use App\Models\PersonalAssignment;
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
        $personal_assignment = PersonalAssignment::query()->findOrFail(
            $this->request->get('personal_assignment_id')
        );

        return $this->user()->can('finish', $personal_assignment);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'personal_assignment_id' => [
                'required',
                'integer',
                'exists:personal_assignments,id',
            ],
        ];
    }
}
