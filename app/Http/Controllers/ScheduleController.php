<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();

        return response()->json([
            'message' => 'Schedules retrieved successfully',
            'schedules' => $schedules,
        ]);
    }

    public function createSchedule(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required',
            'scheduled_at' => 'required|date',
        ]);

        $schedule = Schedule::create($validatedData);

        return response()->json([
            'message' => 'Schedule created successfully',
            'schedule' => $schedule,
        ]);
    }

    public function updateSchedule(Request $request, $id)
    {
        $validatedData = $request->validate([
            'description' => 'required',
            'scheduled_at' => 'required|date',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->update($validatedData);

        return response()->json([
            'message' => 'Schedule updated successfully',
            'schedule' => $schedule,
        ]);
    }

    public function deleteSchedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return response()->json([
            'message' => 'Schedule deleted successfully',
        ]);
    }
}
