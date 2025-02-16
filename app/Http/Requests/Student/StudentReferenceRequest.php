<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\BaseRequestForWeb;
use Illuminate\Contracts\Validation\ValidationRule;

class StudentReferenceRequest extends BaseRequestForWeb
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
            'id' => 'required|exists:student_references,id'
        ];
    }
}
