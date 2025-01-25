<?php

namespace App\Http\Resources\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'course_name' => $this->name,
            'status' => $this->status,
            'course_type' => $this->type,
            'duration' => $this->duration,
            'stream_name' => $this->stream->name,
            'enrollment' => implode(', ', $this->stream->enrollments->pluck('name')->toArray()),
            'created_at' => $this->created_at->format('d-m-Y'),
        ];
    }
}
