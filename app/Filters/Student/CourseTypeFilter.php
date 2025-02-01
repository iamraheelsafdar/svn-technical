<?php

namespace App\Filters\Student;

use Closure;

class CourseTypeFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('course_type') && request()->input('course_type') != null) {
            $query->whereHas('course', function ($query) {
                $query->where('type', 'like', '%' . request()->input('course_type') . '%');
            });
        }
        return $next($query);
    }
}
