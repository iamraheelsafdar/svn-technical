<?php

namespace App\Filters\Center;

use Carbon\Carbon;
use Closure;

class RegistrationPrefixFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('prefix') && request()->input('prefix') != null) {
            $query->where('registration_prefix', 'like', '%' . urldecode(request()->input('prefix')) . '%');
        }
        return $next($query);
    }
}
