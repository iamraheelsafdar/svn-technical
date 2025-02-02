<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function course(): HasOne
    {
        return $this->hasOne(Course::class, 'id', 'course_id');
    }

    public function center(): HasOne
    {
        return $this->hasOne(Center::class, 'id', 'center_id');
    }

    public function stream(): HasOne
    {
        return $this->hasOne(SvnStream::class, 'id', 'stream_id');
    }

}
