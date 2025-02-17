<?php

namespace App\Http\Requests\Student;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequestForWeb;
use Illuminate\Validation\Rule;

class AddStudentRequest extends BaseRequestForWeb
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
            'course' => 'required|exists:courses,id',
            'student_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'dob' => 'required|date_format:d-m-Y|before:today',
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'state' => ['required', Rule::in(["Andaman and Nicobar Islands", "Andhra Pradesh", "Arunachal
                Pradesh", "Assam", "Bihar", "Chandigarh", "Chhattisgarh", "Dadra and Nagar Haveli", "Daman and
                Diu", "Delhi", "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jammu and
                Kashmir", "Jharkhand", "Karnataka", "Lakshadweep", "Puducherry", "Kerala", "Madhya
                Pradesh", "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab", "Rajasthan", "Sikkim", "Tamil
                Nadu", "Telangana", "Tripura", "Uttarakhand", "Uttar Pradesh", "West Bengal"])],
            'mode' => ['required', Rule::in(["online", "regular", "dm", "online", "skill based"])],
            'admission_date' => 'required|date_format:d-m-Y',
            'student_signature' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'student_id' => 'required|file|mimes:jpg,jpeg,png|max:1024',
            'student_qualification' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'student_image' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'lateral' => 'string',
            'lateral_duration' => 'integer|min:0',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'course_id.required' => 'The course field is required.',
            'dob.before' => 'Date of birth must be a valid date before today.',
            'photo.image' => 'The photo must be a valid image file.',
            'signature.image' => 'The signature must be a valid image file.',
        ];
    }
}
