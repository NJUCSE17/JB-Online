<?php

namespace App\Http\Requests\Backend\Forum\Notice;

use App\Rules\Sanitize;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreNoticeRequest.
 */
class StoreNoticeRequest extends FormRequest
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
            'content'  => [new Sanitize(), 'max:10000'],
            'sendmail' => 'required',
        ];
    }
}
