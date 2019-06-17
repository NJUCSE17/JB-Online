<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->route('user');

        return $this->user()->can('update', $user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route('user');
        return [
            'name'          => ['sometimes', 'required', 'string', 'max:255'],
            'email'         => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'blog_feed_url' => [
                'sometimes',
                'nullable',
                'string',
                'url',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password'      => ['sometimes', 'required', 'string', 'min:8'],
            'new_password'  => ['sometimes', 'required', 'string', 'min:8'],
        ];
    }
}
