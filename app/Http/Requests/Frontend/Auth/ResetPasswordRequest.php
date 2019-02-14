<?php

namespace App\Http\Requests\Frontend\Auth;

use App\Rules\Auth\ChangePassword;
use App\Rules\Auth\UnusedPassword;
use App\Rules\Sanitize;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ResetPasswordRequest.
 */
class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => 'required',
            'email' => ['required', 'email', new Sanitize()],
            'password'     => [
                'required',
                'confirmed',
                new Sanitize(),
                new ChangePassword(),
                new UnusedPassword($this->get('token')),
            ],
        ];
    }
}
