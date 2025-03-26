<?php

namespace Eren\Lms\Action;

use Closure;
use Eren\Lms\Classes\LmsCarbon;
use Eren\Lms\Helpers\UploadData;
use Eren\Lms\Models\InstructorPayment;
use Eren\Lms\Models\Media;
use Eren\Lms\Models\OfflinePayment;
use Eren\Lms\Models\Setting;
use Eren\Lms\Models\WithdrawPayment;
use Illuminate\Http\Request;

class WithdrawPaymentAction
{

    protected $uploadData;

    public function __construct()
    {
        $this->uploadData = new UploadData;
        $this->uploadData = $this->uploadData->enableVideoUploading();
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  callable  $next
     * @return mixed
     */
    public function handle($data, Closure $next)
    {
        $min_bank_limit = WithdrawPayment::first();
        $data["min_bank_limit"] = $min_bank_limit;

        return $next($data);
    }
}
