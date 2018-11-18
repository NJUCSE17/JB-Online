<?php

namespace App\Http\Requests\Backend\Forum\Course;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateCourseRequest.
 */
class UpdateCourseRequest extends FormRequest
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
        clean($_POST['notice']);
        return [
            'name' => 'required|max:200',
            'semester'  => ['required', 'int', 'max:20'],
            'start_time' => ['required', 'date', 'max:200', 'date_format:Y-m-d'],
            'end_time' => ['required', 'date', 'max:200', 'date_format:Y-m-d'],
            'notice' => 'max:10000',
            'difficulty' => ['required', 'int', 'max:1000'],
            'restrict_level' => ['required', 'int', 'max:20'],
        ];
    }
}
