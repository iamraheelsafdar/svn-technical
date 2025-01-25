<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stream(): BelongsTo
    {
        return $this->belongsTo(SvnStream::class, 'stream_id');
    }

    public function prefix(): HasOne
    {
        return $this->hasOne(Prefix::class, 'id', 'prefix_id');
    }
}
