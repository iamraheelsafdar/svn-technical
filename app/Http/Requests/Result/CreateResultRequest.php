<?php

namespace App\Http\Requests\Result;

use App\Http\Requests\BaseRequestForWeb;
use Illuminate\Contracts\Validation\ValidationRule;

class CreateResultRequest extends BaseRequestForWeb
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
        $rules = [
            'course_id' => 'required|exists:courses,id', // Ensure course_id exists
            'subjects' => 'required|array', // Subjects must be an array
        ];

        foreach ($this->input('subjects') as $duration => $subjects) {
            foreach ($subjects as $key => $subject) {
                $rules["subjects.$duration.$key.id"] = 'required|exists:subjects,id';
                $rules["subjects.$duration.$key.obtained_marks"] = 'required|integer|min:0';
                $rules["subjects.$duration.$key.min_marks"] = 'required|integer|min:0';
                $rules["subjects.$duration.$key.max_marks"] = 'required|integer|min:0';

                // Ensure min_marks is not greater than max_marks
                $rules["subjects.$duration.$key.min_marks"] = function ($attribute, $value, $fail) use ($subject) {
                    if (isset($subject['max_marks']) && $value > $subject['max_marks']) {
                        $fail('Minimum marks cannot be greater than maximum marks.');
                    }
                };

                $rules["subjects.$duration.$key.obtained_marks"] = function ($attribute, $value, $fail) use ($subject) {
                    if (isset($subject['max_marks']) && $value > $subject['max_marks']) {
                        $fail('Obtained marks cannot be greater than maximum marks.');
                    }
                };

                // Fix: Validate is_practical as a string (either "true" or "false")
                $rules["subjects.$duration.$key.is_practical"] = 'required|string|in:true,false';

                // Practical Marks should be required only when is_practical is "true"
                if ($subject['is_practical'] === 'true') {
                    $rules["subjects.$duration.$key.practical_min_marks"] = 'required|integer|min:0';
                    $rules["subjects.$duration.$key.practical_obtained_marks"] = 'required|integer|min:0';
                    $rules["subjects.$duration.$key.practical_max_marks"] = 'required|integer|min:0';

                    // Ensure practical_min_marks is not greater than practical_max_marks
                    $rules["subjects.$duration.$key.practical_min_marks"] = function ($attribute, $value, $fail) use ($subject) {
                        if (isset($subject['practical_max_marks']) && $value > $subject['practical_max_marks']) {
                            $fail('Practical minimum marks cannot be greater than practical maximum marks.');
                        }
                    };

                    $rules["subjects.$duration.$key.practical_obtained_marks"] = function ($attribute, $value, $fail) use ($subject) {
                        if (isset($subject['practical_max_marks']) && $value > $subject['practical_max_marks']) {
                            $fail('Practical obtained marks cannot be greater than practical maximum marks.');
                        }
                    };
                } else {
                    // If not practical, practical marks should be nullable
                    $rules["subjects.$duration.$key.practical_min_marks"] = 'nullable|integer|min:0';
                    $rules["subjects.$duration.$key.practical_max_marks"] = 'nullable|integer|min:0';
                }
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'course_id.required' => 'Course is required.',
            'course_id.exists' => 'The selected course is invalid.',
            'subjects.required' => 'Subjects data is required.',
            'subjects.array' => 'Subjects data must be an array.',
            'subjects.*.*.id.required' => 'Subject ID is required.',
            'subjects.*.*.id.exists' => 'The selected subject is invalid.',
            'subjects.*.*.min_marks.required' => 'Min marks are required.',
            'subjects.*.*.min_marks.integer' => 'Min marks must be an integer.',
            'subjects.*.*.min_marks.min' => 'Min marks must be at least 0.',
            'subjects.*.*.max_marks.required' => 'Max marks are required.',
            'subjects.*.*.max_marks.integer' => 'Max marks must be an integer.',
            'subjects.*.*.max_marks.min' => 'Max marks must be at least 0.',
            'subjects.*.*.min_marks.*' => 'Minimum marks cannot be greater than maximum marks.',
            'subjects.*.*.is_practical.required' => 'Is practical field is required.',
            'subjects.*.*.is_practical.in' => 'Is practical must be "true" or "false".',
            'subjects.*.*.practical_min_marks.required' => 'Practical min marks are required when subject is practical.',
            'subjects.*.*.practical_min_marks.integer' => 'Practical min marks must be an integer.',
            'subjects.*.*.practical_max_marks.required' => 'Practical max marks are required when subject is practical.',
            'subjects.*.*.practical_max_marks.integer' => 'Practical max marks must be an integer.',
            'subjects.*.*.practical_min_marks.*' => 'Practical minimum marks cannot be greater than practical maximum marks.',
        ];
    }
}
