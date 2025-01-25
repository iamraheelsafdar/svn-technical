<?php

namespace App\Filters\Course;

use Closure;

class CourseStreamFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('stream_name') && request()->input('stream_name') != null) {
            $query->wherehas('stream', function ($q) {
                $q->where('name', 'like', '%' . urldecode(request()->input('stream_name')) . '%');
            });
        }
        return $next($query);
    }
}
