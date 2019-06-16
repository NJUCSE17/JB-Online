<?php

namespace App\Http\Requests\Course;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;

class ViewCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $course = $this->route('course');

        return $this->user()->can('show', $course);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'semester'     => [
                'sometimes',
                'required',
                'integer',
                'between:1,20',
            ],
            'start_before' => [
                'sometimes',
                'required',
                'date_format:Y-m-d H:i:s',
            ],
            'end_after'    => [
                'required_with:start_before',
                'date_format:Y-m-d H:i:s',
                'after_or_equal:start_before',
            ],
        ];
    }
}
