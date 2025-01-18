<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequestForApi extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        // Redirect back with the errors
        throw new HttpResponseException(response()->json(['errors' => $errors], 400));
    }
}
