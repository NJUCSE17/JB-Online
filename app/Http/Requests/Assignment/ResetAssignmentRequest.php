<?php

namespace App\Http\Requests\Assignment;

use App\Models\Assignment;
use Illuminate\Foundation\Http\FormRequest;

class ResetAssignmentRequest extends FormRequest
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

        return $this->user()->can('reset', $assignment);
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
        ];
    }
}
