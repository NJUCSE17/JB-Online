<?php

namespace App\Http\Requests\Problem;

use App\Models\Problem;
use Illuminate\Foundation\Http\FormRequest;

class DeleteProblemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $problem = $this->route('problem');

        return $this->user()->can('delete', $problem);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
