<?php

namespace Eren\Lms\Controllers;

use Eren\Lms\Classes\LmsCarbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use Spatie\Health\Commands\RunHealthChecksCommand;
use Spatie\Health\Health;
use Spatie\Health\ResultStores\ResultStore;

class HealthCheckResultsController {
    public function __invoke(Request $request, ResultStore $resultStore, Health $health): JsonResponse|View {
        if ($request->has('fresh')) {
            Artisan::call(RunHealthChecksCommand::class);
        }
        $checkResults = $resultStore->latestResults();

        return view('lms::health', [
            'lastRanAt' =>  LmsCarbon::setDate($checkResults?->finishedAt),
            'checkResults' => $checkResults,
            'assets' => $health->assets(),
            'theme' => config('health.theme'),
        ]);
    }
}
