<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskLog;
use App\Models\Task;
use App\Models\TaskLogFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Resources\TaskResource;

class TaskLogController extends Controller
{
    //  SUCCESS RESPONSE
    private function success($message, $data = [])
    {
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => $message,
            'data' => (object) $data
        ]);
    }

    //  ERROR RESPONSE
    private function error($message)
    {
        return response()->json([
            'code' => 422,
            'status' => false,
            'message' => $message,
            'data' => (object) []
        ]);
    }

    private function validateBasic($request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required|exists:tasks,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            abort(response()->json([
                'code' => 422,
                'status' => false,
                'message' => $validator->errors()->first(),
                'data' => (object) []
            ]));
        }

        return $validator->validated();
    }

    //  VALIDATE TASK OWNERSHIP
    private function getTask($taskId)
    {
        $task = Task::where('id', $taskId)
            ->where('assigned_to', auth()->id())
            ->first();
        if (!$task) {
            abort(response()->json([
                'code' => 422,
                'status' => false,
                'message' => 'Task not found or unauthorized',
                'data' => (object) []
            ]));
        }

        return $task;
    }

    //  CREATE LOG
    private function log($taskId, $action)
    {
        return TaskLog::create([
            'task_id' => $taskId,
            'action' => $action,
            'action_at' => now(),
            'latitude' => request('latitude'),
            'longitude' => request('longitude'),
        ]);
    }

    //  LAST ACTION
    private function lastAction($taskId)
    {
        return TaskLog::where('task_id', $taskId)
            ->latest()
            ->first();
    }

    //  CHECK JOB STARTED
    private function isStarted($taskId)
    {
        return TaskLog::where('task_id', $taskId)
            ->where('action', 'start_job')
            ->exists();
    }

    // =========================================================

    //  START JOB (ONLY ONCE)
    public function startJob(Request $request)
    {
        $this->validateBasic($request);
        $task = $this->getTask($request->task_id);

        if ($this->isStarted($request->task_id)) {
            return $this->error('Job already started');
        }

        $this->log($request->task_id, 'start_job');
        //  update task status
        $task->update([
            'status' => 'in_progress',
            'started_at' => now()
        ]);

        return $this->success('Job started successfully');
    }

    // =========================================================

    //  CHECK-IN (ONLY ONCE)
    public function checkIn(Request $request)
    {
        $this->validateBasic($request);
        $this->getTask($request->task_id);

        if (!$this->isStarted($request->task_id)) {
            return $this->error('Start job first');
        }

        $alreadyCheckedIn = TaskLog::where('task_id', $request->task_id)
            ->where('action', 'check_in')
            ->exists();

        if ($alreadyCheckedIn) {
            return $this->error('Already checked in');
        }

        $this->log($request->task_id, 'check_in');

        return $this->success('Checked in');
    }

    // =========================================================

    //  WORK START (MULTIPLE TIMES)
    public function workStart(Request $request)
    {
        $this->validateBasic($request);
        $this->getTask($request->task_id);

        $last = $this->lastAction($request->task_id);

        if (!$last || !in_array($last->action, ['check_in', 'work_end'])) {
            return $this->error('Invalid flow');
        }

        $this->log($request->task_id, 'work_start');

        return $this->success('Work started');
    }

    // =========================================================

    //  WORK END (MULTIPLE TIMES)
    public function workEnd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required|exists:tasks,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'status' => 'required|in:pending,completed',
            'comment' => 'nullable|string',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,mp4,mov,avi|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => 422,
                'message' => $validator->errors()->first(),
                'data' => (object) []
            ], 422);
        }

        $task = $this->getTask($request->task_id);

        $last = $this->lastAction($request->task_id);

        if (!$last || $last->action !== 'work_start') {
            return $this->error('Start work first');
        }

        //  Create work_end log
        $log = TaskLog::create([
            'task_id' => $request->task_id,
            'action' => 'work_end',
            'action_at' => now(),
            'status' => $request->status,
            'comment' => $request->comment,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        //  Upload multiple files
        if ($request->hasFile('files')) {
            $files = is_array($request->file('files'))
                ? $request->file('files')
                : [$request->file('files')];

            foreach ($files as $file) {
                //  Detect type
                $mime = $file->getMimeType();
                if (str_starts_with($mime, 'image/')) {
                    $type = 'image';
                } elseif (str_starts_with($mime, 'video/')) {
                    $type = 'video';
                } else {
                    $type = 'document';
                }

                //  Custom filename
                $extension = $file->getClientOriginalExtension();
                $fileName = 'task_' . $request->task_id . '_' . time() . '_' . Str::random(3) . '.' . $extension;
                $path = $file->storeAs('task_logs', $fileName, 'public');
                TaskLogFile::create([
                    'task_log_id' => $log->id,
                    'file_path' => $path,
                    'file_type' => $type
                ]);
            }
        }

        //  update task status
        if ($request->status === 'completed') {
            $task->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);
        }
        // $this->log($request->task_id, 'work_end');

        return $this->success('Work ended');
    }

    // =========================================================

    //  CHECK-OUT (ONLY ONCE)
    public function checkOut(Request $request)
    {
        $this->validateBasic($request);
        $this->getTask($request->task_id);

        $alreadyCheckedOut = TaskLog::where('task_id', $request->task_id)
            ->where('action', 'check_out')
            ->exists();

        if ($alreadyCheckedOut) {
            return $this->error('Already checked out');
        }

        $last = $this->lastAction($request->task_id);

        if (!$last || $last->action !== 'work_end') {
            return $this->error('End work first');
        }

        $this->log($request->task_id, 'check_out');

        return $this->success('Checked out');
    }

    // =========================================================

    public function employeeTaskList()
    {
        $tasks = Task::where('assigned_to', auth()->id())
            // ->with(['logs.files'])
            ->whereIn('status', ['assigned', 'in_progress'])
            ->latest()
            ->get();
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => $tasks->isEmpty() ? 'No tasks found' : 'Task list fetched',
            'data' => $tasks->isEmpty() ? [] : TaskResource::collection($tasks)
        ]);
    }

}
