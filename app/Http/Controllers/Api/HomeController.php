<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Attendance;

class HomeController extends Controller
{
    public function homePage()
    {
        // Total Pending/In Progress Tasks
        $totalTaskCount = Task::where('assigned_to', auth()->id())
            ->where('status', '!=', 'completed')
            ->count();

        // Today's Task Query
        $todayTaskQuery = Task::where('assigned_to', auth()->id())
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());

        // Today's Total Tasks
        $todayTaskCount = (clone $todayTaskQuery)->count();

        // Today's Completed Tasks
        $todayTaskDoneCount = (clone $todayTaskQuery)
            ->where('status', 'completed')
            ->count();

        // Today's Active Tasks
        $todayTaskActiveCount = (clone $todayTaskQuery)
            ->where('status', 'in_progress')
            ->count();

        // Today's Pending Tasks
        $todayTaskPendingCount = (clone $todayTaskQuery)
            ->where('status', 'pending')
            ->count();

        // Today's Attendance
        $todayAttendance = Attendance::where('user_id', auth()->id())
            ->whereDate('date', now())
            ->first();

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Home data fetched successfully',
            'data' => [
                'home_top' => [
                    'total' => $totalTaskCount,
                    'today' => $todayTaskCount,
                    'done' => $todayTaskDoneCount,
                    'active' => $todayTaskActiveCount,
                ],
                  'today' => [
                    'today' => $todayTaskCount,
                    'done' => $todayTaskDoneCount,
                    'active' => $todayTaskActiveCount,
                    'pending' => $todayTaskPendingCount,
                ],

                'today_attendance' =>[
                    'status' =>  $todayAttendance ? $todayAttendance->status : 'absent',
                    'time' => $todayAttendance ? date('h:i A', strtotime($todayAttendance->time)) : null,
                   'date' => $todayAttendance? date('d M Y', strtotime($todayAttendance->date)) : null,
                ]
               
            ]
        ]);
    }
}