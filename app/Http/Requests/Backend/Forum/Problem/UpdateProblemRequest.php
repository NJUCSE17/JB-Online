<?php

namespace App\Http\Requests\Backend\Forum\Problem;

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
        clean($_POST['permalink']);
        clean($_POST['content']);
        return [
            'permalink' => 'max:500',
            'content' => 'required|max:500',
            'difficulty' => 'integer',
        ];
    }
}