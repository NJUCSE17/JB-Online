<?php

namespace App\Http\Requests\Frontend\User;

use App\Rules\Sanitize;
use Illuminate\Validation\Rule;
use App\Helpers\Frontend\Auth\Socialite;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateProfileRequest.
 */
class UpdateProfileRequest extends FormRequest
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
            'first_name' => ['required', new Sanitize(), 'max:191'],
            'last_name' => [new Sanitize(), 'max:191'],
            'email' => ['sometimes', 'required', new Sanitize(), 'email', 'max:191'],
            'blog' => [new Sanitize(), 'max:191'],
            'want_mail' => 'required|min:0|max:1',
            'avatar_type' => ['required', new Sanitize(), 'max:191', Rule::in(array_merge(['gravatar', 'storage'], (new Socialite)->getAcceptedProviders()))],
            'avatar_location' => ['sometimes', new Sanitize(), 'image', 'max:100', 'dimensions:max_width=200,max_height=200',]
        ];
    }
}
