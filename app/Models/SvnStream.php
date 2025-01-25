<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class SvnStream extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'stream_id', 'id');
    }
}
