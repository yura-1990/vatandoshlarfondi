<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateExpertSuggestionRequest extends FormRequest
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
            'image' => ['nullable', File::types(['png', 'jpg', 'jpeg', 'heic'])],
        ];
    }
}
