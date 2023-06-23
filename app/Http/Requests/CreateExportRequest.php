<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateExportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'institution' => 'required',
            'institution_location_id' => 'required',
            'faculty' => 'required',
            'specialization' => 'required',
            'working_company' => 'nullable',
            'working_company_location_id' => 'required',
            'working_position' => 'nullable',
            'working_start_date' => 'nullable',
            'working_finish_date' => 'nullable',
            'total_experience' => 'nullable',
            'academic_degree' => 'nullable',
            'scientific_title' => 'nullable',
            'main_science_directions' => 'nullable',
            'topic_of_scientific_article' => 'nullable',
            'scientific_article_created_at' => 'nullable',
            'article_published_journal_name' => 'nullable',
            'article_url' => 'nullable',
            'article_file' => 'nullable',
            'suggestions' => 'nullable',
            'cv_file' => 'nullable',
            'additional_information' => 'nullable',
        ];
    }
}
