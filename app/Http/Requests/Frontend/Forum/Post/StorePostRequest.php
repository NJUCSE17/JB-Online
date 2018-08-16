<?php

namespace App\Http\Requests\Frontend\Forum\Post;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StorePostRequest.
 */
class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $_POST['user_id'] = $this->user()->id;
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
            'parent_id' => ['required', 'int'],
            'content' => 'required|max:10000'
        ];
    }
}
