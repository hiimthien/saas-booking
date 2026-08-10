<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'consultant_profile_id' => $this->consultant_profile_id,
            'customer_id' => $this->customer_id,
            'start_time' => $this->start_time->toIso8601String(),
            'end_time' => $this->end_time->toIso8601String(),
            'consultant_fee' => $this->consultant_fee,
            'platform_fee' => $this->platform_fee,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'meeting_link' => $this->meeting_link,
            'notes' => $this->notes,
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
