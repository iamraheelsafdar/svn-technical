<?php

namespace App\Http\Requests\Subject;

use App\Http\Requests\BaseRequestForWeb;
use Illuminate\Contracts\Validation\ValidationRule;

class AddSubjectRequest extends BaseRequestForWeb
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
     * @return array[]
     */
    public function rules()
    {
        return [
            'subjects' => ['required', 'array', 'min:1'], // Ensure subjects is an array with at least one entry

            // Validate that every field inside the subjects array is also an array
            'subjects.*.name' => ['required', 'array', 'min:1'], // Validate name as an array
            'subjects.*.name.*' => ['required', 'string', 'max:255'], // Each name should be a string

            'subjects.*.code' => ['required', 'array', 'min:1'], // Validate code as an array
            'subjects.*.code.*' => ['required', 'string', 'max:100'], // Each code should be a string

            'subjects.*.min_marks' => ['required', 'array', 'min:1'], // Validate min_marks as an array
            'subjects.*.min_marks.*' => ['required', 'integer', 'min:0'], // Each min_marks should be an integer

            'subjects.*.max_marks' => ['required', 'array', 'min:1'], // Validate max_marks as an array
            'subjects.*.max_marks.*' => ['required', 'integer', 'gte:subjects.*.min_marks.*'], // Max >= Min

            'subjects.*.is_practical' => ['required', 'array', 'min:1'], // Validate is_practical as an array
            'subjects.*.is_practical.*' => ['required', 'max:5'], // Each is_practical should be a boolean

            'subjects.*.practical_min_marks' => ['nullable', 'array', 'min:1'], // Validate practical_min_marks as an array
            'subjects.*.practical_min_marks.*' => [
                'nullable',
                'required_if:subjects.*.is_practical.*,true',
                'integer',
                'min:0',
                'lt:subjects.*.practical_max_marks.*', // Practical Min < Practical Max
            ],

            'subjects.*.practical_max_marks' => ['nullable', 'array', 'min:1'], // Validate practical_max_marks as an array
            'subjects.*.practical_max_marks.*' => [
                'nullable',
                'required_if:subjects.*.is_practical.*,true',
                'integer',
                'gte:subjects.*.practical_min_marks.*', // Practical Max >= Practical Min
            ],
        ];
    }

    public function messages()
    {
        return [
            'subjects.required' => 'The subjects field is required.',
            'subjects.array' => 'The subjects field must be an array.',
            'subjects.*.name.*.required' => 'Each subject must have a name.',
            'subjects.*.code.*.required' => 'Each subject must have a code.',
            'subjects.*.min_marks.*.required' => 'Min marks are required for each subject.',
            'subjects.*.max_marks.*.gte' => 'Max marks must be greater than or equal to Min marks.',
            'subjects.*.practical_min_marks.*.required_if' => 'Practical min marks are required when the subject is practical.',
            'subjects.*.practical_max_marks.*.gte' => 'Practical max marks must be greater than or equal to Practical min marks.',
        ];
    }
}
