<?php

namespace App\Filters\Center;

use Closure;

class CenterStatusFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('status') && request()->input('status') != null) {
            $query->wherehas('user', function ($q) {
                $q->where('status', urldecode(request()->input('status')));
            });
        }
        return $next($query);
    }
}
