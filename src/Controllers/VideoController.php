<?php

namespace Eren\Lms\Controllers;

use Eren\Lms\Action\CourseStatusAction;
use Eren\Lms\Action\MediaAction;
use Eren\Lms\Action\UploadVideoAction;
use Eren\Lms\Action\ValidateVideo;
use Eren\Lms\Contracts\VideoUploadContract;
use Illuminate\Http\Request;
use Eren\Lms\Models\Course;
use Eren\Lms\Models\CourseStatus;
use Eren\Lms\Models\Media;
use Eren\Lms\Models\Lecture;
use Eren\Lms\Models\ResVideo;
use Eren\Lms\Classes\LmsCarbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Eren\Lms\Helpers\UploadData;
use Illuminate\Routing\Pipeline;


class VideoController extends Controller
{
    protected $uploadData;
    private $st_path;

    public function __construct()
    {
        $this->uploadData = new UploadData;
        $this->uploadData = $this->uploadData->enableVideoUploading();
        $this->st_path = "storage/";
    }

    function validate_user($course_id)
    {
        return Course::where([['user_id', Auth::id()], ['id', $course_id]])->firstOrFail();
    }

    public function set_video_free(Request $request, $media_id)
    {
        try {
            $media = Media::where("id", $media_id)->first();
            if (!empty($media)) {
                $set_free = !empty($request->set_free) ? 1 : 0;
                $set_download = !empty($request->set_download) ? 1 : 0;

                $media->is_free = $set_free;

                $media->is_download = $set_download;

                $media->save();
                $debug = "";
                if (config("app.debug")) {
                    $debug = [
                        "media_id" => $media->id,
                        "set_free" => $media->set_free,
                        "old_set_free" => $set_free
                    ];
                }
                return response()->json([
                    'success' => true,
                    "media_title" => $media->lec_name,
                    "debug" => $debug
                ]);
            } else {
                return response()->json([
                    'err' => config("setting.err_msg", 400),
                ]);
            }
        } catch (Exception $e) {
            if (config("app.debug")) {
                dd($e->getMessage());
            } else {
                return response()->json([
                    'err' => config("setting.err_msg", 400),
                ]);
            }
        }
    }
    public function upload_video($course_id, $lecture_id, Request $request)
    {
        $data = [];
        $data['course_id'] = $course_id;
        $data['lecture_id'] = $lecture_id;
        $data['request'] = $request;
        $data['upload_video'] = "upload_video";


        return (new Pipeline(app()))->send($data)->through(array_filter([
            UploadVideoAction::class,
            MediaAction::class,
            CourseStatusAction::class
        ]))->then(function ($data){
            return app(VideoUploadContract::class, ["data" => $data]);
        });
    }

    public function delete_video(Request $request, $course_id, $media_id)
    {
        if ($request->ajax()) {
            $this->validate_user($course_id);
            $media = Media::findOrFail($media_id);
            $lec_id = $media->lecture_id;

            if ($media) {
                $file_name = $media->lec_name;
                $media->delete();
                return response()->json([
                    'status' => 'video has been deleted',
                    'video_url' => route('upload_video', ['course_id' => $course_id, 'lecture_id' => $lec_id])
                ]);
            }
        }
    }

    public function delete_uploaded_video(Request $request, $lec_id)
    {
        if ($request->ajax()) {
            $lec = ResVideo::findOrFail($lec_id);
            $this->validate_user($lec->lecture->course->id);
            if ($lec) {
                $file_name = $lec->lec_path;
                // debug_dump($file_name);
                if ($file_name) {
                    // $f_path = public_path('storage/'.$file_name);
                    $f_path = Storage::disk('s3')->exists($file_name);
                    if ($f_path) {
                        // unlink($f_path);
                        Storage::disk('s3')->delete($f_path);
                    }
                    $lec->delete();
                    return response()->json([
                        'status' => 'video has been deleted',
                        'upload_video_url' => route('upload_vid_res', ['lec_id' => $lec->lecture->id])
                    ]);
                } else {
                    return response()->json([
                        'error' => 'video was not deleted because of some issues'
                    ]);
                }
            }
        }
    }

    public function uploadBulkLoader(Request $request, $course)
    {
        if ($request->ajax()) {
            $request->validate([
                'upload_b_vid.*' => 'required|max:4000000|mimetypes:video/mp4,video/webm,video/ogg'
            ]);

            $course = Course::findOrFail($course);
            $files = $request->file('upload_b_vid');

            foreach ($files as $file) {
                $f_name = $file->getClientOriginalName();
                $f_mimetype = $file->getClientMimeType();

                $path = $file->store('uploads', 'public');
                $media = new Media;
                $media->lec_name = $path;
                $media->f_name = $f_name;
                $media->f_mimetype = $f_mimetype;
                $media->course_id = $course->id;
                $media->save();
            }
            return response()->json(
                'All video files have been saved'
            );
        } else {
            abort(403);
        }
    }

    public function edit_video($course_id, $media_id, Request $request)
    {
        $data = [];
        $data['course_id'] = $course_id;
        $data['media_id'] = $media_id;
        $data['request'] = $request;
        $data['upload_video'] = "edit_video";

        return (new Pipeline(app()))->send($data)->through(array_filter([
            UploadVideoAction::class,
            MediaAction::class,
            CourseStatusAction::class
        ]))->then(function ($data){
            return app(VideoUploadContract::class, ["data" => $data]);
        });
    }
}
