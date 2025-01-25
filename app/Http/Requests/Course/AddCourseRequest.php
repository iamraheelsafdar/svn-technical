<?php

namespace App\Http\Requests\Course;

use App\Http\Requests\BaseRequestForWeb;
use Illuminate\Contracts\Validation\ValidationRule;

class AddCourseRequest extends BaseRequestForWeb
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
            "course_name" => "required|string|max:100",
            "course_code" => "required|string|max:100",
            "course_type" => ["required", "in:year,semester,monthly"],
            "duration" => ["required", "string", request()->course_type == "year" ? "max:12" : (request()->course_type == "semester" ? "max:30" : "max:20")],
            "roll_number_prefix" => "required|string|exists:prefixes,id",
            "stream_name" => "required|string|exists:svn_streams,id",
            "enrollment" => "required|string|exists:enrollments,id",
        ];
    }
}
