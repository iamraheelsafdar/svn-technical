<?php

namespace App\Filters\Course;

use Carbon\Carbon;
use Closure;

class CourseCreatedFilter
{
    public function handle($query, Closure $next)
    {
        if (request()->has('date') && request()->input('date') != null) {
            $date = Carbon::parse(request()->input('date'))->toDateString();
            $query->whereBetween('created_at', [$date . " 00:00:00", $date . " 23:59:59"]);
        }
        return $next($query);
    }
}
