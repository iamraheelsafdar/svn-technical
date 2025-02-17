<?php

namespace App\Http\Requests\Student;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequestForWeb;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends BaseRequestForWeb
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
            'student_name' => 'required|max:100',
            'father_name' => 'required|max:100',
            'mother_name' => 'required|max:100',
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'mode' => ['required', Rule::in(["online", "regular", "dm", "online", "skill based"])],
            'reference_id' => 'nullable|exists:student_references,id'
        ];
    }
}
