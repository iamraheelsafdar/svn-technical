<?php

namespace App\Filters\Student;

use Closure;

class CourseNameFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('course_name') && request()->input('course_name') != null) {
            $query->whereHas('course', function ($query) {
                $query->where('name', 'like', '%' . request()->input('course_name') . '%');
            });
        }
        return $next($query);
    }
}
