<?php

namespace App\Http\Requests\Course;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequestForWeb;

class CheckCourseRequest extends BaseRequestForWeb
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
            'id' => 'required|exists:courses,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Course id is required',
            'id.exists' => 'Course is not available',
        ];
    }
}
