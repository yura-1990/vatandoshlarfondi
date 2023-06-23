<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserEducationInfoRequest extends FormRequest
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
            'expert' => 'required|array',
            [
                'expert.*.institution' => 'nullable|string',
                'expert.*.level' => 'nullable|string',
                'expert.*.faculty' => 'nullable|string',
                'expert.*.specialization_id' => 'nullable',
                'expert.*.type' => 'nullable'
            ]
        ];
    }
}
