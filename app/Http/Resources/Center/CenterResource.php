<?php

namespace App\Http\Resources\Center;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CenterResource extends JsonResource
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
            'name' => $this->user->name,
            'owner_name' => $this->owner_name,
            'registration_prefix' => $this->registration_prefix,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'address' => $this->address,
            'status' => $this->user->status,
            'last_login' => $this->user->last_login ? Carbon::parse($this->user->last_login)->diffForHumans() : '-',
            'state' => $this->state,
            'registration_date' => $this->created_at->format('d-m-Y'),
        ];
    }
}
