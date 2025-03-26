<?php

namespace Eren\Lms\Action;

use Closure;
use Eren\Lms\Classes\LmsCarbon;
use Eren\Lms\Helpers\UploadData;
use Eren\Lms\Models\InstructorPayment;
use Eren\Lms\Models\Media;
use Illuminate\Http\Request;

class InstructorAction
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
        $setting = InstructorPayment::where('user_id', auth()->id())->first();
        $data["setting"] = $setting;

        return $next($data);
    }
}
