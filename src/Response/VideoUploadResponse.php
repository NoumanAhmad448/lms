<?php

namespace Eren\Lms\Response;

use Exception;
use Eren\Lms\Classes\LmsCarbon;
use Eren\Lms\Helpers\UploadData;
use Eren\Lms\Contracts\VideoUploadContract as ContractsVideoUploadContract;
use Eren\Lms\Models\Course;
use Eren\Lms\Models\CourseStatus;
use Eren\Lms\Models\Lecture;
use Eren\Lms\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoUploadResponse implements ContractsVideoUploadContract
{

    protected $uploadData;
    private $data;

    public function __construct($data)
    {
        $this->uploadData = new UploadData;
        $this->uploadData = $this->uploadData->enableVideoUploading();

        $this->data = $data;
    }

    public function toResponse($request)
    {
        try {
            return response()->json([
                'path' => $this->data['path'],
                'media' => $this->data['media'],
                'delete' => route('delete_video', ['course_id' => $this->data['course_id'], 'media_id' => $this->data['media']->id]),
                'f_name' => reduceCharIfAv($this->data['f_name'], 30)
            ]);
        } catch (Exception $d) {
            return server_logs($e = [true, $d], $request = [true, $request], $config = true);
        }
    }
}
