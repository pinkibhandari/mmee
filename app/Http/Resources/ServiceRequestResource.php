<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestResource extends JsonResource
{
   public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'service' => [
                'id' => $this->service?->id,
                'name' => $this->service?->name,
            ],

            'user' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'phone' => $this->user?->phone,
            ],

            'description' => $this->description,
            'priority' => $this->priority,
            'status' => $this->status,

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'assigned_at' => $this->assigned_at?->format('Y-m-d H:i:s'),
            'completed_at' => $this->completed_at?->format('Y-m-d H:i:s'),
        ];
    }
}
