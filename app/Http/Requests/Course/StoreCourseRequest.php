<?php

namespace App\Http\Requests\Course;

use App\Models\Course;
use App\Rules\Sanitize;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Course::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => ['required', new Sanitize(), 'max:200'],
            'semester'   => ['required', 'integer', 'between:1,20'],
            'start_time' => ['required', 'date_format:Y-m-d H:i:s'],
            'end_time'   => [
                'required',
                'date_format:Y-m-d H:i:s',
                'after_or_equal:start_before',
            ],
            'notice'     => ['sometimes', 'required', new Sanitize(), 'max:10000'],
        ];
    }
}
