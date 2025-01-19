<?php

namespace App\Filters\Prefix;

use Closure;

class PrefixStatusFilter
{

    public function handle($query, Closure $next)
    {
        if (request()->has('status') && request()->input('status') != null) {
            $query->where('status', 'like', '%' . urldecode(request()->input('status')) . '%');
        }
        return $next($query);
    }
}
