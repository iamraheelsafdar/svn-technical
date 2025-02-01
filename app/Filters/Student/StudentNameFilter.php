<?php

namespace App\Filters\Student;

use Closure;

class StudentNameFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('student_name') && request()->input('student_name') != null) {
            $query->where('name', 'like', '%' . urldecode(request()->input('student_name')) . '%');
        }
        return $next($query);
    }
}
