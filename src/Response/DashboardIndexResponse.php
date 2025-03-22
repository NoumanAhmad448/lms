<?php

namespace Eren\Lms\Response;

use Exception;
use Eren\Lms\Contracts\DashboardIndexContract;

class DashboardIndexResponse implements DashboardIndexContract
{

    private $data;

    public function __construct($data)
    {

        $this->data = $data;
    }

    public function toResponse($request)
    {
        try {
            $title = __('lms::messages.dashboard');
            $respnse = [
                'courses' => $this->data['courses'],
                'title' => $title,
                'ann' => $this->data['ann'],
            ];
            return $request->wantsJson()
                ? response()->json($respnse) : view('lms::dashboard', $respnse);
        } catch (Exception $th) {
            debug_logs($th->getMessage());
            return $request->wantsJson() ? '' : redirect()->route(config("lms.index_route") ?? 'index');
        }
    }
}
