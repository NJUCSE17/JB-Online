<?php

namespace App\Http\Requests\Course;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class QuitCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $course = $this->route('course');

        if ($this->request->has('user_id')) {
            $target = User::query()->findOrFail($this->request->getInt('user_id'))->get();
            return $this->user()->can('quitOther', $course, $target);
        } else {
            return $this->user()->can('quitSelf', $course);
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
            'user_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:users,id',
            ],
        ];
    }
}
