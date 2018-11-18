<?php

namespace App\Http\Requests\Frontend\Forum\Personal;

use App\Models\Forum\Assignment;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreAssignmentRequest.
 */
class StoreAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        clean($_POST['name']);
        clean($_POST['content']);
        return [
            'name' => 'required|max:200',
            'content' => 'required|max:10000',
            'due_time' => ['required', 'date', 'max:200', 'date_format:Y-m-d G:i:s'],
        ];
    }
}
