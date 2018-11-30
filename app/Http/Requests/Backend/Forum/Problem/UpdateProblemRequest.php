<?php

namespace App\Http\Requests\Backend\Forum\Problem;

use App\Rules\Sanitize;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateProblemRequest.
 */
class UpdateProblemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isExecutive();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'permalink' => [new Sanitize(), 'max:500'],
            'content' => ['required', new Sanitize(), 'max:500'],
            'difficulty' => 'integer',
        ];
    }
}