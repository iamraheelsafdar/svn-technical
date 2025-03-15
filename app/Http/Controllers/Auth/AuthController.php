<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\SetPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Jobs\Mail\SetPasswordMailJob;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        if ($user->remember_token != null) {
            session()->flash('validation_errors', ['Your account is not verfied. Please verify your account.']);
            return redirect()->route('loginPage');
        }
        if ($user->status != 1) {
            session()->flash('validation_errors', ['Your account is not active. Please contact admin to activate your account.']);
            return redirect()->route('loginPage');
        }
        if (!Hash::check($request->password, $user->password)) {
            session()->flash('validation_errors', ['Provided credentials are invalid.']);
            return redirect()->route('loginPage');
        }
        Auth::login($user);
        session()->flash('success', 'You are successfully logged in.');
        return redirect()->intended('dashboard');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function forgotPassword(Request $request): RedirectResponse
    {
        session()->flash('success', 'If an account exists, we will send you an email to reset your password.');
        $user = User::where('email', $request->email)->where('status', 1)->first();
        if ($user) {
            $token = Str::random(64);
            $updatedUser = tap($user)->update(['remember_token' => $token]);
            SetPasswordMailJob::dispatch($updatedUser);
        }
        return redirect()->route('loginPage');
    }

    public function setPasswordView($email, $token)
    {
        $user = User::where('email', $email)
            ->where('remember_token', $token)
            ->where('updated_at', '>=', now()->subHours(24)) // Check if token is less than 24 hours old
            ->first();
        if ($user) {
            return view('mail.set-password', ['user' => $user]);
        }
        session()->flash('validation_errors', ['❌ This requested link has expired!']);
        return redirect()->route('loginPage');
    }

    public function setPassword(SetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)
            ->where('remember_token', $request->remember_token)
            ->where('updated_at', '>=', now()->subHours(24)) // Check if token is less than 24 hours old
            ->first();
        if ($user) {
            $user->update(['password' => Hash::make($request->password) , 'remember_token'=>null,'status'=>1]);
            session()->flash('success', 'You have set your password successfully');
            return redirect()->route('loginPage');
        }
        session()->flash('validation_errors', ['❌ This requested link has expired!']);
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
