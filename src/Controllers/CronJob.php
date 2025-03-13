<?php

namespace Eren\Lms\Controllers;

use Eren\Lms\Models\CronJobs;
use Illuminate\Http\Request;

class CronJob extends Controller
{
    public function getCronJob()
    {
        $cron_jobs = CronJobs::paginate(config('setting.cron_paginate'));
        debug_logs($cron_jobs);
        return view('lms::dev.cron_jobs.get_cron_jobs', compact('cron_jobs'));
    }
}
