<?php

namespace Eren\Lms\Response;

use Eren\Lms\Contracts\LandingPageContract;
use Illuminate\Support\Facades\Auth;

class LandingPageResponse implements LandingPageContract
{

    private $data;

    public function __construct($data)
    {

        $this->data = $data;
    }

    public function toResponse($request)
    {
        $response = [
            'course' => $this->data['course'],
            'categories' => $this->data['categories']
        ];
        try {
            if (optional($this->data['course'])->user_id == Auth::id()) {
                return $request->wantsJson() ?
                    response()->json($response) :
                    view('lms::courses.landing_page', $response);
            }

            return $request->wantsJson() ?
                response()->json([], 403) :
                abort(403);
        } catch (\Throwable $th) {
            debug_logs($th->getMessage());
            return $request->wantsJson() ?
                response()->json([], 403) :
                back();
        }
    }
}
