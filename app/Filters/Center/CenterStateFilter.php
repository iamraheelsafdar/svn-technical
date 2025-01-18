<?php

namespace App\Filters\Center;

use Closure;

class CenterStateFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('state') && request()->input('state') != null) {
            $query->where('state', 'like', '%' . urldecode(request()->input('state')) . '%');
        }
        return $next($query);
    }
}
