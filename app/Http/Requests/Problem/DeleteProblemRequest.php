<?php

namespace App\Http\Requests\Problem;

use Illuminate\Foundation\Http\FormRequest;

class DeleteProblemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // TODO: PERMISSIONS
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'problem_id' => ['required', 'int', 'exists:problems,id'],
        ];
    }
}
