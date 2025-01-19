<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequestForWeb;
use Illuminate\Contracts\Validation\ValidationRule;

class LoginRequest extends BaseRequestForWeb
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
            'email' => ['required', 'exists:users,email', 'email'],
            'password' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => 'Provided credentials are invalid.',
        ];
    }
}
