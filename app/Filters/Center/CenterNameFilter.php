<?php

namespace App\Filters\Center;

use Closure;

class CenterNameFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('name') && request()->input('name') != null) {
            $query->wherehas('user', function ($q) {
                $q->where('name', 'like', '%' . urldecode(request()->input('name')) . '%');
            });
        }
        if (request()->has('owner_name') && request()->input('owner_name') != null) {
            $query->where('owner_name', 'like', '%' . urldecode(request()->input('owner_name')) . '%');
        }
        return $next($query);
    }
}
