<?php

namespace Eren\Lms\Action;

use Closure;
use Eren\Lms\Classes\LmsCarbon;
use Eren\Lms\Helpers\UploadData;
use Eren\Lms\Models\Media;
use Illuminate\Http\Request;

class MediaAction
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
        $f_name = $data["f_name"];
        $f_mimetype = $data["f_mimetype"];
        $duration = $data["duration"];
        $time_mili = $data["time_mili"];

        if(key_exists("media_id", $data)){
            $media = Media::where("id", $data['media_id'])->first();
        }else{
            $media = new Media();
        }
        if(!empty($data["lecture_id"])){
            $media->lecture_id = $data['lecture_id'];
        }
        $media->lec_name = $path;
        $media->f_name = $f_name;
        $media->course_id = $data['course_id'];
        $media->f_mimetype = $f_mimetype;
        $media->duration = $duration;
        $media->time_in_mili = $time_mili;
        $media->is_free = !empty($request->set_free) ? 1 : 0;
        $media->is_download = !empty($request->set_download) ? 1 : 0;
        if(key_exists("media_id", $data)){
            $media->update();
        }else{
            $media->save();
        }

        $data["media"] = $media;

        return $next($data);
    }
}
