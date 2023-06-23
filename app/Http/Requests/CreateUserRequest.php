<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'second_name' => 'required',
            'last_name' => 'nullable',
            'national_address' => 'nullable',
            'international_location_id' => 'nullable',
            'international_address_id' => 'nullable',
            'national_id' => 'nullable',
            'birth_date' => 'nullable',
            'gender' => 'nullable',
            'academic_degree' => 'nullable',
            'phone_number' => 'nullable',
            'scientific_title' => 'nullable',
            'job_position' => 'nullable',
            'work_experience' => 'nullable',
            'additional_info' => 'nullable',
            'achievements' => 'nullable',
            'family_status' => 'nullable',
            'hobbies' => 'nullable',
            'interests' => 'nullable',
            'opinions_about_uzbekistan' => 'nullable',
            'suggestions_and_recommendations' => 'nullable',
            'timezone' => 'nullable',
            'language' => 'nullable',
            'passport_file' => ['nullable', File::types(['pdf','doc', 'docx', 'png', 'jpg', 'jpeg', 'heic'])],
            'avatar_url' => ['nullable', File::types(['png', 'jpg', 'jpeg', 'heic'])],
        ];
    }
}
