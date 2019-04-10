<?php

namespace App\Http\Requests\User;

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
        return [
            'name'          => ['sometimes', 'required', 'string', 'max:255'],
            'email'         => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ],
            'blog_feed_url' => [
                'sometimes',
                'required',
                'string',
                'url',
                'max:255',
                'unique:users',
            ],
            'password'      => ['sometimes', 'required', 'string', 'min:8'],
        ];
    }
}
