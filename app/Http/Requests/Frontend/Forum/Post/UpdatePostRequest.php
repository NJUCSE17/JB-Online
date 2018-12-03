<?php

namespace App\Http\Requests\Frontend\Forum\Post;

use App\Rules\Sanitize;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdatePostRequest.
 */
class UpdatePostRequest extends FormRequest
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
            'content' => ['required', new Sanitize(), 'max:10000']
        ];
    }
}
