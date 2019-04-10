<?php

namespace App\Http\Requests\Problem;

use App\Models\Problem;
use Illuminate\Foundation\Http\FormRequest;

class ViewProblemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('view', Problem::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'assignment_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:assignments,id',
            ],
            'course_id'     => [
                'sometimes',
                'required',
                'integer',
                'exists:courses,id',
            ],
        ];
    }
}
