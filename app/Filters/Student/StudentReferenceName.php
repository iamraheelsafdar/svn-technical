<?php

namespace App\Filters\Student;

use Closure;

class StudentReferenceName
{
    public function handle($query, Closure $next)
    {
        if (request()->has('reference') && request()->input('reference') != null) {
            $query->where('reference', 'like', '%' . urldecode(request()->input('reference')) . '%');
        }
        return $next($query);
    }
}
