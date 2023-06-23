<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserEmploymentInfoRequest extends FormRequest
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
                'expert.*.company' => 'required|string',
                'expert.*.position' => 'required|string',
                'expert.*.location_id' => 'required|number',
                'expert.*.status' => 'nullable|number',
                'expert.*.city' => 'required|string',
                'expert.*.start_date' => 'required|string',
                'expert.*.finish_date' => 'nullable|string',
                'expert.*.specialization' => 'required|string',
            ]
        ];
    }
}
