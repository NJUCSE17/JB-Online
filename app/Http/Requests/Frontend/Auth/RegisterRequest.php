<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterRequest.
 */
class RegisterRequest extends FormRequest
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
        clean($_POST['student_id']);
        clean($_POST['first_name']);
        clean($_POST['last_name']);
        clean($_POST['email']);
        clean($_POST['blog']);
        clean($_POST['password']);
        return [
            'student_id'           => ['required', 'int', 'min:100000000', 'max:300000000', Rule::unique('users')],
            'first_name'           => 'required|string|max:191',
            'last_name'            => 'max:191',
            'email'                => ['required', 'string', 'email', 'max:191', Rule::unique('users')],
            'blog'                 => 'max:191',
            'password'             => 'required|string|min:6|confirmed',
            'g-recaptcha-response' => ['required_if:captcha_status,true', new CaptchaRule()],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'g-recaptcha-response.required_if' => __('validation.required', ['attribute' => 'captcha']),
        ];
    }
}
