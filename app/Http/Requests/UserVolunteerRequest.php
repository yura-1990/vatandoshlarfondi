<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UserVolunteerRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'images' => 'nullable|array',
            'images.*' => ['nullable', File::types(['png', 'jpg', 'jpeg', 'heic'])],
        ];
    }
}
