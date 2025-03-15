<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subjectResult(): HasOne
    {
        return $this->hasOne(StudentResult::class);
    }
}
