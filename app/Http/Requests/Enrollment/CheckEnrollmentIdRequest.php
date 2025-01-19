<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequestForWeb;

class CheckEnrollmentIdRequest extends BaseRequestForWeb
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:enrollments,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Enrollment id is required',
            'id.exists' => 'Enrollment is not available',
        ];
    }
}
