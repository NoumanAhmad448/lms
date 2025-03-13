<?php
namespace Eren\Lms\Controllers;

use Eren\Lms\Models\SyncCommand;

class ScheduleMonitorController extends Controller
{
    public function syncSchedule()
    {
        $output = [];
        $resultCode = null;

        try {
            // Run the sync command
            $tasks = SyncCommand::all();

        return view('lms::dev.schedule_monitor', compact('tasks'));
            $output = implode("\n", $output);
        } catch (\Exception $e) {
            $output = "An error occurred: " . $e->getMessage();
        }

        return view('lms::schedule-monitor.sync', [
            'output' => $output,
            'resultCode' => $resultCode,
        ]);
    }
}
