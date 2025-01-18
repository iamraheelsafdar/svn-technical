<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequestForWeb;

class UpdateEnrollmentRequest extends BaseRequestForWeb
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
            'enrollment_name' => 'required|string|max:50',
            'prefix' => 'required|string|exists:prefixes,id',
            'stream' => 'required|string|exists:svn_streams,id',
            'session_year' => 'required|date_format:Y',
        ];
    }
}
