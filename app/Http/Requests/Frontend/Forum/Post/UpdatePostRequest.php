<?php

namespace App\Http\Requests\Frontend\Forum\Post;

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
        clean($_POST['content']);
        return [
            'content' => 'required|max:10000'
        ];
    }
}
