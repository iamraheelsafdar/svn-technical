<?php

namespace App\Filters\Center;

use Closure;

class CenterEmailFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('email') && request()->input('email') != null) {
            $query->wherehas('user', function ($q) {
                $q->where('email','like', '%' . urldecode(request()->input('email')) . '%');
            });
        }
        return $next($query);
    }
}
