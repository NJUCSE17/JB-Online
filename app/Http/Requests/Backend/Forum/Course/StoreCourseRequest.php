<?php

namespace App\Http\Requests\Backend\Forum\Course;

use App\Rules\Sanitize;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreCourseRequest.
 */
class StoreCourseRequest extends FormRequest
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
            'name' => ['required', new Sanitize(), 'max:200'],
            'semester'  => ['required', 'int', 'max:20'],
            'start_time' => ['required', 'date', 'max:200', 'date_format:Y-m-d'],
            'end_time' => ['required', 'date', 'max:200', 'date_format:Y-m-d'],
            'notice' => [ new Sanitize(), 'max:10000'],
            'difficulty' => ['required', 'int', 'max:1000'],
            'restrict_level' => ['required', 'int', 'max:20'],
        ];
    }
}
