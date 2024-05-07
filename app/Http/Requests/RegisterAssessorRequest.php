<?php

namespace App\Http\Requests;

use App\Rules\AlphaNumericUnderScoreRule;
use App\Rules\AlphaSpaceRule;
use App\Rules\EmailRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterAssessorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', new AlphaSpaceRule()],
            'username' => ['required', new AlphaNumericUnderScoreRule('username')],
            'email' => ['required', 'email', new EmailRule()],
            'password' => ['required', 'min:8'],
            'password_confirmation' => ['required', 'same:password'],
            'phone_number' => ['required', 'numeric'],
            'captcha' => ['required', 'captcha']
        ];
    }
}