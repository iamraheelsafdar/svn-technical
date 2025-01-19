<?php

namespace App\Filters\Enrollment;

use Closure;

class EnrollmentYearFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('enrollment_year') && request()->input('enrollment_year') != null) {
            $query->where('year_start', 'like', '%' . urldecode(request()->input('enrollment_year')) . '%');
        }
        return $next($query);
    }
}
