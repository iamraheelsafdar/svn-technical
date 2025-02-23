<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'lateral' => $this->lateral_entry,
            'course_name' => $this->course->name,
            'course_type' => $this->course->type,
            'course_duration' => $this->course->duration,
            'types' => $this->course->distinct('type')->pluck('type')->toArray(),
            'photo' => $this->photo,
            'steam_name' => $this->course->stream->name,
            'course_id' => $this->course_id,
            'result' => count($this->result->toArray()) > 0
//            'roll_number' => count($this->rollNumbers->pluck('roll_number')->toArray()) > 0
        ];
    }
}
