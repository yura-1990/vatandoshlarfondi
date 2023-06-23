<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserEmploymentInfoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'company' => 'required|string',
            'position' => 'required|string',
            'location_id' => 'required|integer',
            'city' => 'required|string',
            'start_date' => 'required|string',
            'finish_date' => 'nullable|string',
            'specialization' => 'required|string',
        ];
    }
}
