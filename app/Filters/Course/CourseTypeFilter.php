<?php

namespace App\Filters\Course;

use Closure;

class CourseTypeFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('course_type') && request()->input('course_type') != null) {
            $query->where('type', 'like', '%' . urldecode(request()->input('course_type')) . '%');
        }
        return $next($query);
    }
}
