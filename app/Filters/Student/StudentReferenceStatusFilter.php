<?php

namespace App\Filters\Student;

use Closure;

class StudentReferenceStatusFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('status') && request()->input('status') != null) {
            $query->where('status', 'like', '%' . urldecode(request()->input('status')) . '%');
        }
        return $next($query);
    }
}
