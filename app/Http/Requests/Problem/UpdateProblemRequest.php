<?php

namespace App\Http\Requests\Problem;

use App\Rules\Sanitize;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProblemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // TODO: PERMISSION
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => ['required', new Sanitize(), 'max:200'],
        ];
    }
}
