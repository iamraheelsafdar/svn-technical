<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequestForWeb;

class SiteSettingRequest extends BaseRequestForWeb
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
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'logo' => 'mimes:png|max:2048',
            'title' => 'required|string|max:50',
            'copyright' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'logo.mimes' => 'Logo must be in png format',
            'logo.max' => 'Logo must be less than 2MB',
        ];
    }
}
