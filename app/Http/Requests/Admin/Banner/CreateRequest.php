<?php

namespace App\Http\Requests\Admin\Banner;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'name' => 'required',
            'image_file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'order' => 'required|numeric',
            'url' => 'nullable|url',
            'is_active' => 'boolean'
        ];
    }
}
