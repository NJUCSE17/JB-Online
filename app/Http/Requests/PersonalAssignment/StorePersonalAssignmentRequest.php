<?php

namespace App\Http\Requests\Assignment;

use App\Rules\Sanitize;
use Illuminate\Foundation\Http\FormRequest;

class StorePersonalAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // TODO: PREMISSION!!
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'int', 'exists:users,id'],
            'name' => ['required', new Sanitize(), 'max:100'],
            'content' => ['required', new Sanitize(), 'max:2000'],
            'due_time' => ['required', 'date_format:Y-m-d H:i:s'],
        ];
    }
}
