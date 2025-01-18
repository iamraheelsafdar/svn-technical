<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequestForWeb extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        // Flash the error messages to the session
        session()->flash('validation_errors', $errors);

        // Redirect back with the errors
        throw new HttpResponseException(redirect()->back()->withInput());
    }
}
