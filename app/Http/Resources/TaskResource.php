<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // $lastLog = $this->logs->sortByDesc('id')->first();

        return [
            'task_id' => $this->id,
            'task_code' => $this->task_code,
            'title' => $this->title,
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'address' => $this->address,
            'priority' => $this->priority,
            'status' => $this->status,    //  from tasks table
            'due_date' => $this->due_date,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),

            //  from task logs
            // 'last_action' => $lastLog?->action,
            // 'last_action_time' => $lastLog?->action_at,

            //  from task logs files
            // 'files' => $lastLog?->files->map(function ($file) {
            //     return [
            //         'file_url' => asset('storage/' . $file->file_path),
            //         'file_type' => $file->file_type,
            //     ];
            // }) ?? [],
        ];
    }
}
