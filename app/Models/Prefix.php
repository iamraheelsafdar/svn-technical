<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prefix extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

//    public function enrollments()
//    {
//        return $this->morphedByMany(Enrollment::class, 'prefixable');
//    }

//    public function courses()
//    {
//        return $this->morphedByMany(Course::class, 'prefixable');
//    }
}
