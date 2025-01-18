<?php

namespace App\Filters\Enrollment;

use Closure;

class EnrollmentPrefixFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('prefix_name') && request()->input('prefix_name') != null) {
            $query->wherehas('prefix', function ($q) {
                $q->where('prefix','like', '%' . urldecode(request()->input('prefix_name')) . '%');
            });
        }
        return $next($query);
    }
}
