<?php

namespace Eren\Lms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BloggerSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return isAdmin();
    }

}
