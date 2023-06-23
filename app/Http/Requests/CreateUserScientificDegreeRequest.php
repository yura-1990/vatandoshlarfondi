<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CreateUserScientificDegreeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'academic_degree' => 'required|string',
            'scientific_title' => 'required|string',
            'main_science_directions' => 'nullable',
            'topic_of_scientific_article' => 'required|string',
            'scientific_article_created_at' => 'required|string',
            'article_published_journal_name' => 'required|string',
            'article_url' => 'nullable',
            'article_file' => ['nullable', File::types(['pdf','doc', 'docx', 'png', 'jpg', 'jpeg', 'heic'])],
        ];
    }
}
