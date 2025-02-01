<?php

namespace App\Filters\Student;

use Closure;

class StudentLiteralFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('lateral_entry') && request()->input('lateral_entry') != null) {
            $query->where('lateral_entry', 'like', '%' . urldecode(request()->input('lateral_entry')) . '%');
        }
        return $next($query);
    }
}
