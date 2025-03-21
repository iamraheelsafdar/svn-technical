<?php

namespace App\Filters\Student;

use Closure;

class CenterStudent
{
    public function handle($query, Closure $next)
    {
        if (auth()->user()->role == 'Center') {
            $query->where('center_id', auth()->user()->center->id);
        }
        return $next($query);
    }
}
