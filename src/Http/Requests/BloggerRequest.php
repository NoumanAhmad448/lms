<?php

namespace Eren\Lms\Http\Requests;

use Eren\Lms\Rules\IsScriptAttack;
use Eren\Lms\Rules\UniqueNameRule;
use Illuminate\Foundation\Http\FormRequest;

class BloggerRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required',new IsScriptAttack],
            'email' => ['required', new IsScriptAttack, new UniqueNameRule],
            'password' => ['required',new IsScriptAttack,'min:8']
        ];
    }
}
