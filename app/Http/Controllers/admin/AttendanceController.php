<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    // Attendance List
   public function index(Request $request)
{
    $query = Attendance::with('user')->latest();

    // Status Filter
    if ($request->filled('status')) {

        $query->where('status', $request->status);

    }

    $attendances = $query->paginate(10);

    return view('admin.attendance.index', compact('attendances'));
}
}
