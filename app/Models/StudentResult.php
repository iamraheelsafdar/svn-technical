<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentResult extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function student(): HasOne
    {
        return $this->hasOne(Students::class, 'id', 'student_id');
    }
}
