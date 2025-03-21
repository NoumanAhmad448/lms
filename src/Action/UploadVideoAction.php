<?php

namespace Eren\Lms\Action;

use Closure;
use Eren\Lms\Classes\LmsCarbon;
use Eren\Lms\Helpers\UploadData;
use Eren\Lms\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadVideoAction
{

    protected $uploadData;

    public function __construct()
    {
        $this->uploadData = new UploadData;
        $this->uploadData = $this->uploadData->enableVideoUploading();

        // $this->course_id = $course_id;
        // $this->lecture_id = $lecture_id;
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

        php_config();

        $course = $this->validate_user($data['course_id']);
        $request = $data['request'];

        $request->validate([
            $data['upload_video'] => 'required|max:4500000|mimetypes:video/mp4,video/webm,video/ogg'
        ]);

        $file = $request->file($data['upload_video']);
        $f_name = $file->getClientOriginalName();
        $f_mimetype = $file->getClientMimeType();

        $path1 = $file->store('uploads', 'public');

        $path = "uploads";
        $path = $this->uploadData->upload($file, $f_name);

        $getID3 = new \getID3;
        $file = $getID3->analyze(public_path('storage/' . $path1));

        $time_mili = !empty($file) && !empty($file['playtime_seconds']) ? $file['playtime_seconds'] : 2;

        $duration = LmsCarbon::parse($time_mili, "H:i:s");
        if (file_exists(public_path('storage/' . $path1))) {
            // @ supress the error
            @unlink(public_path('storage/' . $path1));
        }

        $data["duration"] = $duration;
        $data["path1"] = $path1;
        $data["path"] = $path;
        $data["f_name"] = $f_name;
        $data["f_mimetype"] = $f_mimetype;
        $data["time_mili"] = $time_mili;
        $data["course"] = $course;

        return $next($data);
    }

    private function validate_user($course_id)
    {
        return Course::where([['user_id', Auth::id()], ['id', $course_id]])->firstOrFail();
    }
}
