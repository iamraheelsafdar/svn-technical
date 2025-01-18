<?php

namespace App\Filters\Enrollment;

use Closure;

class EnrollmentNameFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('enrollment_name') && request()->input('enrollment_name') != null) {
            $query->where('name', 'like', '%' . urldecode(request()->input('enrollment_name')) . '%');
        }
        return $next($query);
    }
}
