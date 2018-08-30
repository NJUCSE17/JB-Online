<?php

namespace App\Http\Requests\Backend\Auth\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreUserRequest.
 */
class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin();
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
            'student_id' => ['required', 'int', 'min:100000000', 'max:300000000', Rule::unique('users')],
            'first_name' => 'required|max:191',
            'last_name'  => 'max:191',
            'email'    => ['required', 'email', 'max:191', Rule::unique('users')],
            'blog'     => 'max:191',
            'password' => 'required|min:6|confirmed',
            'roles' => 'required|array',
        ];
    }
}
