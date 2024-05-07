<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => 'required|email',
            'name' => 'required|max:200|min:3',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'username' => 'required|min:3|alpha_num',
            'role_id' => 'required',
            'region_id' => 'nullable'
        ];
    }
}
