<?php

namespace App\Filters\Prefix;

use Closure;

class PrefixAssignFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('assign_prefix') && request()->input('assign_prefix') != null) {
            $query->where('prefix_assign_to', 'like', '%' . urldecode(request()->input('assign_prefix')) . '%');
        }
        return $next($query);
    }
}
