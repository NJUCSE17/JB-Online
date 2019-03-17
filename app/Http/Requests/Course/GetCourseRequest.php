<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class GetCourseRequest extends FormRequest
{
    /**
     * Override the default all() function to get route parameters.
     *
     * @param null $keys
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all();
        $data['course_id'] = $this->route('course_id');
        return $data;
    }

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
            'course_id' => ['required', 'int', 'min:1'], // TODO: HOW TO VALIDATE THIS ROUTE PARAMETER?
        ];
    }
}
