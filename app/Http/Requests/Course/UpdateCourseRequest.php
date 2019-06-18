<?php

namespace App\Http\Requests\Course;

use App\Rules\Sanitize;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $course = $this->route('course');

        return $this->user()->can('update', $course);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => ['sometimes', 'required', 'max:200'],
            'semester'   => [
                'sometimes',
                'required',
                'integer',
                'between:1,20',
            ],
            'start_time' => [
                'sometimes',
                'required',
                'date_format:Y-m-d H:i:s',
            ],
            'end_time'   => [
                'sometimes',
                'required',
                'date_format:Y-m-d H:i:s',
                'after_or_equal:start_time',
            ],
            'notice'     => [
                'sometimes',
                'nullable',
                new Sanitize(),
                'max:10000',
            ],
        ];
    }
}
