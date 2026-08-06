<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultantProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'hourly_rate' => $this->hourly_rate,
            'bio' => $this->bio,
            'rating' => $this->rating,
            'reviews_count' => $this->reviews_count,
            'is_active' => $this->is_active,
            'user' => new UserResource($this->whenLoaded('user')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'working_hours' => WorkingHourResource::collection($this->whenLoaded('workingHours')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
        ];
    }
}
