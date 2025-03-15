<?php

namespace App\Http\Requests\Prefix;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequestForWeb;

class CheckPrefixIdRequest extends BaseRequestForWeb
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
            'id' => 'required|exists:prefixes,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'The prefix id is required',
            'id.exists' => 'The provided prefix is not available',
        ];
    }
}
