<?php

namespace App\Http\Requests\Assignment;

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
        return $this->user()->can('view', PersonalAssignment::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'personal_assignment_id' => ['sometimes', 'int', 'exists:personal_assignments,id'],
            'due_after'              => ['sometimes', 'date_format:Y-m-d H:i:s'],
            'due_before'             => ['sometimes', 'date_format:Y-m-d H:i:s'],
            'unfinished_only'        => ['sometimes', 'boolean'],
        ];
    }
}
