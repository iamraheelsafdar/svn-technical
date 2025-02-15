<?php

namespace App\Filters\Student;

use Closure;

class StreamNameFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('stream_name') && request()->input('stream_name') != null) {
            $query->whereHas('course.stream', function ($query) {
                $query->where('name', 'like', '%' . request()->input('stream_name') . '%');
            });
        }
        return $next($query);
    }
}
