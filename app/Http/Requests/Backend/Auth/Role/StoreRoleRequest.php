<?php

namespace App\Http\Requests\Backend\Auth\Role;

use App\Rules\Sanitize;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreRoleRequest.
 */
class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                new Sanitize(),
                'unique:roles',
                'max:191',
            ],
        ];
    }
}
