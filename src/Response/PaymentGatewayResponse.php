<?php

namespace Eren\Lms\Response;

use Eren\Lms\Contracts\LandingPageContract;
use Eren\Lms\Contracts\PaymentGatewayContract;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class PaymentGatewayResponse implements PaymentGatewayContract
{

    private $data;

    public function __construct($data)
    {

        $this->data = $data;
        if (!key_exists('title', $data)) {
            $this->data['title'] = 'Payment_gateway';
        }
    }

    public function toResponse($request)
    {

        $response = [
            'title' => $this->data['title'],
            'setting' => $this->data['setting'],
            'a_setting' => $this->data['a_setting'],
            'offline_setting' => $this->data['offline_setting'],
            'min_bank_limit' => $this->data['min_bank_limit'],
        ];
        try {
            return $request->wantsJson() ?
                response()->json($response)
                :
                view('lms::instructor.payment-setting', $response);
        } catch (\Throwable $th) {
            debug_logs($th->getMessage());
            return $request->wantsJson() ?
                response()->json([], 403) :
                back();
        }
    }
}
