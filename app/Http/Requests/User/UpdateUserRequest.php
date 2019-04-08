<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->request->has('user_id')) {
            $user = User::query()->findOrFail($this->request->get('user_id'));

            return $this->user()->can('update', $user);
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
            'user_id'  => [
                'sometimes',
                'required',
                'integer',
                'exists:users,id',
            ],
            'name'     => ['sometimes', 'required', 'string', 'max:255'],
            'email'    => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ],
            'blog'     => [
                'sometimes',
                'required',
                'string',
                'url',
                'max:255',
                'unique:users',
            ],
            'password' => ['sometimes', 'required', 'string', 'min:8'],
        ];
    }
}
