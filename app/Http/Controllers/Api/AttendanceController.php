<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AttendanceController extends Controller
{
    public function markAttendance(Request $request)
    {
        $request->validate([
            'status' => 'required|in:present,absent',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $attendance = Attendance::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'date' => now()->toDateString()
            ],
            [
                'time' => now()->format('H:i:s'),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude, 
                'status' => $request->status
            ]
        );

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Attendance marked successfully',
            'data' => $attendance
        ]);
    }

    public function todayAttendanceStatus()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('date', now())
            ->first();

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Attendance status fetched successfully',
            'data' => [
                'status' => $attendance->status ?? 'absent'
            ]
        ]);
    }

    //  Monthly Listing (FULL CALENDAR)
    public function monthlyAttendance(Request $request)
    {
        $userId = auth()->id();
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $today = now()->toDateString();
        if ($endDate->gt($today)) {
            $endDate = Carbon::parse($today);
        }
        $period = CarbonPeriod::create($startDate, $endDate);
        $result = [];
        foreach ($period as $date) {
            $attendance = Attendance::where('user_id', $userId)
                ->whereDate('date', $date->toDateString())
                ->first();

            $result[] = [
                'date' => $date->toDateString(),
                'status' => $attendance->status ?? 'absent'
            ];
        }
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Monthly attendance fetched successfully',
            'data' => $result
        ]);
    }
}
