<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ReadUserRequest extends FormRequest
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
            'user_id' => ['sometimes', 'int', 'exists:users,id'],
        ];
    }
}
