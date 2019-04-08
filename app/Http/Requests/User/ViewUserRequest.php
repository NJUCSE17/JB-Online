<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ViewUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->request->has('user_id')) {
            $user = User::query()
                ->findOrFail($this->request->getInt('user_id'));

            return $this->user()->can('view', $user);
        } else {
            return true;
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
            'user_id' => ['sometimes', 'required', 'integer', 'exists:users,id'],
        ];
    }
}
