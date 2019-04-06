<?php

namespace App\Http\Requests\PersonalAssignment;

use App\Models\PersonalAssignment;
use Illuminate\Foundation\Http\FormRequest;

class ViewPersonalAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->request->has('personal_assignment_id')) {
            $personal_assignment = PersonalAssignment::query()->findOrFail($this->request->get('personal_assignment_id'));
            return $this->user()->can('view', $personal_assignment);
        } else {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'personal_assignment_id' => ['sometimes', 'required', 'integer', 'exists:personal_assignments,id'],
            'due_after'              => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
            'due_before'             => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
            'unfinished_only'        => ['sometimes', 'required', 'boolean'],
        ];
    }
}
