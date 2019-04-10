<?php

namespace App\Http\Requests\PersonalAssignment;

use Illuminate\Foundation\Http\FormRequest;

class ResetPersonalAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $personalAssignment = $this->route('personalAssignment');

        return $this->user()->can('reset', $personalAssignment);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
