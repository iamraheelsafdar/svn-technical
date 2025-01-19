<?php

namespace App\Filters\Center;

use Closure;

class CenterAddressFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('address') && request()->input('address') != null) {
            $query->where('address', 'like', '%' . urldecode(request()->input('address')) . '%');
        }
        return $next($query);
    }
}
