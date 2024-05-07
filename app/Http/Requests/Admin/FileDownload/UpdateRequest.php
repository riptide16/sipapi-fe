<?php

namespace App\Http\Requests\Admin\FileDownload;

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
            'is_publish' => ['nullable', 'boolean'],
            'filename' => 'required|regex:/^[0-9a-zA-Z ]+$/u|min:3',
            'attachment_file' => ['nullable', 'mimes:png,jpeg,jpg,pdf']
        ];
    }
}
