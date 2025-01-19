<?php

namespace App\Filters\Center;

use Closure;

class CenterPhoneFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('phone') && request()->input('phone') != null) {
            $query->wherehas('user', function ($q) {
                $q->where('phone', 'like', '%' . urldecode(request()->input('phone')) . '%');
            });
        }
        return $next($query);
    }
}
