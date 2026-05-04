<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'service' => [
                'id' => $this->service?->id,
                'name' => $this->service?->name,
                'description' => $this->service?->description,
            ],

            'user' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'phone' => $this->user?->phone,
            ],

            // 'expert' => $this->expert ? [
            //     'id' => $this->expert->id,
            //     'name' => $this->expert->name,
            //     'phone' => $this->expert->phone,
            // ] : null,

            // 'description' => $this->description,
            // 'address' => $this->address,
            // 'latitude' => $this->latitude,
            // 'longitude' => $this->longitude,

            'priority' => $this->priority,
            'status' => $this->status,

            'assigned_at' => $this->assigned_at,
            'completed_at' => $this->completed_at,

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
