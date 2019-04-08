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
            'problem_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:problems,id',
            ],
            'assignment_id' => [
                'required_without:problem_id',
                'integer',
                'exists:assignments,id',
            ],
        ];
    }
}
