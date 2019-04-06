<?php

namespace App\Http\Requests\PersonalAssignment;

use App\Models\PersonalAssignment;
use App\Rules\Sanitize;
use Illuminate\Foundation\Http\FormRequest;

class CreatePersonalAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', PersonalAssignment::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => ['required', new Sanitize(), 'max:100'],
            'content'  => ['required', new Sanitize(), 'max:2000'],
            'due_time' => ['required', 'date_format:Y-m-d H:i:s'],
        ];
    }
}
