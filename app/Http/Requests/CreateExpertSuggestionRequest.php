<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CreateExpertSuggestionRequest extends FormRequest
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
            'suggestions' => 'required',
            'additional_information' => 'required',
            'images' => 'nullable|array',
            'images.*' => ['nullable', File::types(['png', 'jpg', 'jpeg', 'heic'])],
        ];
    }
}
