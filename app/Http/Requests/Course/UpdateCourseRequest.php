<?php

namespace App\Http\Requests\Course;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequestForWeb;

class UpdateCourseRequest extends BaseRequestForWeb
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
            "id" => "required|exists:courses,id",
            "course_name" => "required|string|max:100",
            "course_code" => "required|string|max:100",
            "enrollment" => "required|string|exists:enrollments,id",
            "stream_name" => "required|string|exists:svn_streams,id",
            "course_type" => ["required", "in:year,semester,monthly"],
            "roll_number_prefix" => "required|string|exists:prefixes,id",
            "duration" => ["required", "string", request()->course_type == "year" ? "max:12" : (request()->course_type == "semester" ? "max:30" : "max:20")],
        ];
    }
}
