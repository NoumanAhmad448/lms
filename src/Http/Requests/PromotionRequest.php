<?php

namespace Eren\Lms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Eren\Lms\Models\Course;
use Illuminate\Validation\Rule;

class PromotionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $course = Course::find($this->route('course'));

        return $course && $this->user()->id == $course->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'coupon_no' => 'required|max:255'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'coupon_no.required' => 'Coupon code is required',
            'coupon_no.max' => 'Your Coupon digits should not greater than 255',
        ];
    }
}
