<?php

namespace App\Filters\Course;

use Closure;

class CourseEnrollmentFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('enrollment') && request()->input('enrollment') != null) {
            $query->wherehas('stream.enrollments', function ($q) {
                $q->where('name', 'like', '%' . urldecode(request()->input('enrollment')) . '%');
            });
        }
        return $next($query);
    }
}
