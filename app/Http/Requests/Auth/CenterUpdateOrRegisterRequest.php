<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequestForWeb;
use Illuminate\Validation\Rule;

class CenterUpdateOrRegisterRequest extends BaseRequestForWeb
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
        $validation = [
            'name' => 'required|max:100',
            'phone' => 'required|max:100',
            'email' => 'email|max:50',
            'owner_name' => 'required|max:100',
            'address' => 'required|max:100',
            'state' => ['required', Rule::in(["Andaman and Nicobar Islands", "Andhra Pradesh", "Arunachal
                Pradesh", "Assam", "Bihar", "Chandigarh", "Chhattisgarh", "Dadra and Nagar Haveli", "Daman and
                Diu", "Delhi", "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jammu and
                Kashmir", "Jharkhand", "Karnataka", "Lakshadweep", "Puducherry", "Kerala", "Madhya
                Pradesh", "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab", "Rajasthan", "Sikkim", "Tamil
                Nadu", "Telangana", "Tripura", "Uttarakhand", "Uttar Pradesh", "West Bengal"])]
        ];
        if (request()->routeIs('addCenter')) {
            $validation['email'] = 'required|email|max:100|unique:users';
            $validation['profile_image'] = 'required|mimes:png,jpg,jpeg|max:2048';
        }
        if (request()->routeIs('updateCenter')) {
            $validation['id'] = ['required', 'exists:centers,id'];
            $validation['profile_image'] = 'mimes:png,jpg,jpeg|max:2048';
        }
        return $validation;
    }

    public function messages(): array
    {
        return [
            'profile_image.mimes' => 'The center logo must be in png, jpg, jpeg format',
            'profile_image.max' => 'The center logo size must be less than 2MB',
            'profile_image.required' => 'The center logo is required',
        ];
    }
}
