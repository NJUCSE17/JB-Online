<?php

namespace App\Http\Requests\Backend\Auth\User;

use App\Rules\Sanitize;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateUserRequest.
 */
class UpdateUserRequest extends FormRequest
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
        return [
            'student_id' => [
                'required',
                'int',
                new Sanitize(),
                'min:100000000',
                'max:300000000',
            ],
            'first_name' => [
                'required',
                new Sanitize(),
                'max:191',
            ],
            'last_name'  => [
                new Sanitize(),
                'max:191',
            ],
            'email' => [
                'required',
                'email',
                new Sanitize(),
                'max:191',
            ],
            'blog'     => [
                new Sanitize(),
                'max:191',
            ],
            'roles' => 'required|array',
        ];
    }
}
