<?php

namespace Eren\Lms\Action;

use Closure;
use Eren\Lms\Classes\LmsCarbon;
use Eren\Lms\Helpers\UploadData;
use Eren\Lms\Models\InstructorPayment;
use Eren\Lms\Models\Media;
use Eren\Lms\Models\OfflinePayment;
use Eren\Lms\Models\Setting;
use Illuminate\Http\Request;

class OfflinePaymentAction
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
        $offline_setting = OfflinePayment::first();
        $data["offline_setting"] = $offline_setting;

        return $next($data);
    }
}
