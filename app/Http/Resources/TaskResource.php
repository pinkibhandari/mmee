<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
         $lastLog = $this->logs->sortByDesc('id')->first();
         $lastAction = $lastLog?->action;
            if ($lastLog && $lastLog->action === 'work_end' && $lastLog->status === 'pending' ) {
                $lastAction = 'check_in';
            }

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
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => $this->created_at,
            // pause and resume times can be calculated from logs if needed
            'is_timer_running' => $this->is_timer_running,  //  from tasks table
            'timer_started_at' => $this->timer_started_at,  //  from tasks table
            'total_work_seconds' => $this->total_work_seconds,  //  from tasks table

            'employee_name' => $this->employee?->name,    //  from users table

            //  from task logs
             'last_action' => $lastAction ,
             'last_action_time' => $lastLog?->action_at,

            //  from task logs files
            'files' => $lastLog?->files->map(function ($file) {
                return [
                    'file_url' => asset('storage/public/' . $file->file_path),
                    'file_type' => $file->file_type,
                ];
            }) ?? [],
        ];
    }
}
