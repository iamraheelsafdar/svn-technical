<?php

namespace App\Http\Resources\Enrollment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
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
            'enrollment_name' => $this->name,
            'enrollment_year' => $this->year_start,
            'prefix_name' => $this->prefix->prefix ?? '',
            'stream_name' => $this->stream->name ?? '',
            'status' => $this->status,
            'created_at' => $this->created_at->format('d-m-Y'),
        ];
    }
}
