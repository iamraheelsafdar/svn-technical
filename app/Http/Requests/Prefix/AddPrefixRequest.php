<?php

namespace App\Http\Requests\Prefix;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequestForWeb;
use Illuminate\Validation\Rule;

class AddPrefixRequest extends BaseRequestForWeb
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
            'prefix_name' => 'required|string|max:50',
            'assign_prefix' => ['required', Rule::in(['Course Management', 'Svn Enrollment'])],
        ];
    }
}
