<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCommunityRequest extends FormRequest
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
     * @return array<object, Rule|array|object>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'logo' => 'required|string',
            'document' => 'required|string',
            'director' => 'required|string',
            'director_img' => 'required|string',
            'director_date' => 'required|string',
            'work' => 'required|string',
            'created_date' => 'required|string',
            'members' => 'required|integer',
            'achievement' => 'required|string',
            'region_id' => 'required|integer',
            'city_id' => 'required|integer',
            'phone' => 'required|string',
            'email' => 'required|string',
            'address' => 'required|string',
            'site' => 'required|string',
            'attachments' => 'required|array',
        ];
    }
}
