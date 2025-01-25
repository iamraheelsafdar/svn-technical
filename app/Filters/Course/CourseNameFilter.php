<?php

namespace App\Filters\Course;

use Closure;

class CourseNameFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('course_name') && request()->input('course_name') != null) {
            $query->where('name', 'like', '%' . urldecode(request()->input('course_name')) . '%');
        }
        return $next($query);
    }
}
