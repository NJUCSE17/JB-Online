<?php

namespace App\Http\Requests\PersonalAssignment;

use App\Models\PersonalAssignment;
use Illuminate\Foundation\Http\FormRequest;

class ViewPersonalAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->request->has('show_all') or $this->request->has('user_id')) {
            return $this->user()->privilege_level <= 2;
        } else {
            return $this->user()->can('view', PersonalAssignment::class);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'show_all'        => ['sometimes', 'required', 'boolean'],
            'user_id'         => [
                'sometimes',
                'required',
                'integer',
                'exists:users,id',
            ],
            'due_after'       => [
                'sometimes',
                'required',
                'date_format:Y-m-d H:i:s',
            ],
            'due_before'      => [
                'sometimes',
                'required',
                'date_format:Y-m-d H:i:s',
            ],
            'unfinished_only' => ['sometimes', 'required', 'boolean'],
        ];
    }
}
