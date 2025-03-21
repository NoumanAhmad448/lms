<?php

namespace Eren\Lms\Controllers;

use Eren\Lms\Action\CategoriesAction;
use Eren\Lms\Contracts\LandingPageContract;
use Eren\Lms\Http\Requests\LandingPage;

use Eren\Lms\Http\Requests\CourseImageUpload;
use Eren\Lms\Http\Requests\CourseVideoRequest;
use Eren\Lms\Models\Categories;
use Eren\Lms\Models\Course;
use Eren\Lms\Models\CourseImage;
use Eren\Lms\Models\CourseVideo;
use Exception;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Eren\Lms\Helpers\UploadData;
use Illuminate\Routing\Pipeline;

class LandingPageController extends Controller
{
    protected $uploadData;

    public function __construct() {
        $this->uploadData = new UploadData();
    }
    public function landing_page(Course $course)
    {
        $data = ["course" => $course];

        return (new Pipeline(app()))->send($data)->through(array_filter([
            CategoriesAction::class,
        ]))->then(function ($data){
            return app(LandingPageContract::class, ["data" => $data]);
        });
    }
    public function store_landing_page(LandingPage $request, $course)
    {
        try {
            $request->validated();

            $course  = Course::findOrFail($course);

            $course_title = $request->course_title;
            $course_desc = $request->course_desc;
            $select_level = $request->select_level;
            $select_category = $request->select_category;


            if (is_xss($course_title) || is_xss($course_desc) || is_xss($select_level) || is_xss($select_category)) {
                abort(403);
            }

            $course->c_level = $select_level;
            $course->description = $course_desc;
            $course->course_title = $course_title;
            $course->categories_selection = $select_category;
            $course->lang_id = $request->lang;
            $course->save();

            changeCourseStatus($course->id, 20, 'landing_page');

            return response()->json([
                'status' => 'Your information has been saved',
            ]);
        } catch (\Throwable $th) {
            return back();
        }
    }


    public function course_img(CourseImageUpload $request, $course)
    {
        try {
            php_config();
            $request->validated();

            $file = $request->file('course_img');
            $manager = new ImageManager();

            $image = $manager->make($file)->resize(300, 200);
            $name = $file->getClientOriginalName();
            $path = "storage/img/".time() . uniqid() . str_replace(' ', '-',$name);

            $path = $this->uploadData->upload($image->stream()->__toString(), $name);

            $extension = $file->extension();
            $course = Course::findOrFail($course);
            $course_img = $course->course_image;

            if ($course_img) {
                $prev_p = $course_img->image_path;

                $course_img->image_path = $path;
                $course_img->image_name = $name;
                $course_img->image_ex = $extension;
                $course_img->save();

                return response()->json([
                    'status' => 'saved',
                    'img_path' => config("setting.s3Url").$path,
                ]);
            }

            $course_img = new CourseImage;
            $course_img->course_id = $course->id;
            $course_img->image_path = $path;
            $course_img->image_name = $name;
            $course_img->image_ex = $extension;
            $course_img->save();

            changeCourseStatus($course->id, 5, 'course_img');

            return response()->json([
                'status' => 'saved',
                'img_path' => config("setting.s3Url").$path,
            ]);
        } catch (Exception $e) {
            return server_logs($e=[true,$e], $request=[true,$request],$config=true);
        }
    }


    public function course_vid(CourseVideoRequest $request, $course)
    {
        try {
            php_config();
            $request->validated();
            $course = Course::findOrFail($course);
            $file = $request->file('course_vid');

            $file_path = 'uploads';

            $f_mime_type = $file->getClientMimeType();
            $f_name = $file->getClientOriginalName();

            $file_path = $this->uploadData->enableVideoUploading()->upload($file, $f_name);


            $course_vid = $course->course_vid;
            if ($course_vid) {
                $course_vid->video_name = $f_name;
                $course_vid->video_type = $f_mime_type;
                $course_vid->vid_path = $file_path;
                $course_vid->save();

                return response()->json([
                    'video_path' => $this->uploadData->url($file_path),
                    'video_type' => $f_mime_type
                ]);
            } else {
                $c_vid = new CourseVideo;
                $c_vid->course_id = $course->id;
                $c_vid->video_name = $f_name;
                $c_vid->video_type = $f_mime_type;
                $c_vid->vid_path = $file_path;
                $c_vid->save();

                changeCourseStatus($course->id, 5, 'course_video');
                return response()->json([
                    'video_path' =>  $this->uploadData->url($file_path),
                    'video_type' => $f_mime_type
                ]);
            }
        } catch (\Throwable $e) {
            if(config("app.debug")){
                server_logs($e=[true,$e], $request=[true,$request],$config=true);
            }else{
                return response()->json(['course_vid', config("setting.err_msg")],500);
            }
        }
    }
}
