<?php

namespace App\Filters\Prefix;

use Closure;

class PrefixNameFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('prefix_name') && request()->input('prefix_name') != null) {
            $query->where('prefix', 'like', '%' . urldecode(request()->input('prefix_name')) . '%');
        }
        return $next($query);
    }
}
