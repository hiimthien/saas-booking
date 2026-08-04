<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultantProfileResource extends JsonResource
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
            'slug' => $this->slug,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'avatar_url' => $this->user->avatar_url,
            ],
            'title' => $this->title,
            'hourly_rate' => $this->hourly_rate,
            'bio' => $this->bio,
            'rating' => $this->rating,
            'reviews_count' => $this->reviews_count,
            'tags' => clone $this->tags->pluck('name'),
            'is_active' => $this->is_active,
            'working_hours' => $this->whenLoaded('workingHours'),
        ];
    }
}
