<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();
        if (!Hash::check($request->password, $user->password)) {
            session()->flash('validation_errors', ['Provided credentials are invalid.']);
            return redirect()->route('loginPage');
        }
        Auth::login($user);
        session()->flash('success', 'You are successfully logged in.');
        return redirect()->intended('dashboard');
    }

    /**
     * @return RedirectResponse
     */
    public function forgotPassword(): RedirectResponse
    {
        session()->flash('success', 'If an account exists, we will send you an email to reset your password.');
        return redirect()->route('loginPage');
    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        session()->flash('success', 'You are successfully logged out.');
        return redirect()->route('loginPage');
    }
}
