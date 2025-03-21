<?php

namespace Eren\Lms\Action;

use Closure;
use Eren\Lms\Classes\LmsCarbon;
use Eren\Lms\Helpers\UploadData;
use Eren\Lms\Models\CourseStatus;
use Eren\Lms\Models\Media;
use Illuminate\Http\Request;

class CourseStatusAction
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

        $path = $data["path"];
        $course = $data["course"];

        $c_status = CourseStatus::where('course_id', $data["course_id"])->first();
        if ($c_status) {
            $path = config('setting.s3Url') . $path;
            $c_status->curriculum = 40;
            $c_status->save();
        }

        optional($course)->updated_at = now();
        $course->save();

        return $next($data);
    }
}
