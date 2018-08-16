<?php

namespace App\Http\Requests\Backend\Forum\Assignment;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateAssignmentRequest.
 */
class UpdateAssignmentRequest extends FormRequest
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
        clean($_POST['name']);
        clean($_POST['content']);
        return [
            'course_id'  => ['required', 'int'],
            'name' => 'required|max:200',
            'content' => 'required|max:10000',
            'due_time' => ['required', 'date', 'max:200'],
        ];
    }
}
