<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Attendance;

class HomeController extends Controller
{
    public function homePage(){
        $totalTaskCount = Task::where('assigned_to', auth()->id())
                     ->count();
        $todayAttendance = Attendance::where('user_id', auth()->id())
            ->whereDate('date', now())
            ->first();
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Employee Task List fetched successfully',
            'data' => [
                'total_tasks' => $totalTaskCount,
                'today_attendance' => $todayAttendance ? $todayAttendance->status : 'absent'
            ]
        ]); 
    }
}
