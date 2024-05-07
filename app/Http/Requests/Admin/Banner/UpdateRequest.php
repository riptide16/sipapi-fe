<?php

namespace App\Http\Requests\Admin\Banner;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|max:191',
            'order' => 'required|numeric|min:1',
            'url' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'boolean'
        ];
    }
}
