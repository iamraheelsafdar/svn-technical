<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RequestLogsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user() && (in_array(Route::currentRouteName(), ['loginPage', 'forgotPassword', 'forgotPasswordPage' ,'setPasswordView']))) {
            // Redirect authenticated users away from login or forget password pages
            return redirect()->route('dashboardView'); // Or any other page you want to redirect to
        }
        return $next($request);
    }
}
