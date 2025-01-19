<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\BaseRequestForWeb;
use Illuminate\Contracts\Validation\ValidationRule;

class ProfileSettingRequest extends BaseRequestForWeb
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
        $valid = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'profile_image' => 'mimes:png,jpg,jpeg|max:2048',
        ];
        if (request()->new_password) {
            $valid['new_password'] = 'min:8';
            $valid['old_password'] = 'required|max:255';
        }
        return $valid;
    }

    public function messages(): array
    {
        return [
            'profile_image.mimes' => 'Profile image must be png, jpg, jpeg',
            'profile_image.max' => 'Profile image must not exceed 2 MB.',
        ];
    }
}
