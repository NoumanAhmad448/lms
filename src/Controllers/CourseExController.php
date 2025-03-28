<?php

namespace Eren\Lms\Controllers;

use Eren\Lms\Models\Certificate;
use Eren\Lms\Models\Comment;
use Illuminate\Http\Request;
use Eren\Lms\Models\Course;
use Eren\Lms\Models\Media;
use Eren\Lms\Models\RatingModal;
use Eren\Lms\Models\User;
use Eren\Lms\Rules\IsScriptAttack;
use Exception;
use Eren\Lms\Classes\LmsCarbon;
use Eren\Lms\Classes\PdfReader;

class CourseExController extends Controller
{

    public function ratingCourse(Request $request)
    {
        try {
            $rating_no = $request->rating_no;
            $course_slug = $request->course;
            $course = Course::where('slug', $course_slug)->first();

            if (!$course) {
                abort(403);
            }
            $c_id = $course->id;
            $user_id = auth()->id();
            $rating_modal = RatingModal::where([['student_id', '=', $user_id], ['course_id', '=', $c_id]])->first();
            if ($rating_modal) {
                $rating_modal->rating = $rating_no;
                $rating_modal->save();
            } else {
                RatingModal::Create(['course_id' => $c_id, 'student_id' => $user_id, 'rating' => $rating_no]);
            }

            return response()->json(['message' => 'done']);
        } catch (\Throwable $th) {
            return response()->json(['error' => config("setting.err_msg") . $th->getMessage()], 500);
        }
    }

    public function downloadCert($slug)
    {
        $cert_no = rand();
        $course = Course::where("slug", $slug)->first();
        if(!$course){
            abort(404);
        }
        $certificate = Certificate::fetchOrCreateCertificate(auth()->id(), $course->id);

        $d = ['course' => $course->name, 'cert_no' => $certificate->code];

        return PdfReader::getPdf($d);
    }

    public function comment($course_name)
    {
        try {
            $course = Course::where('slug', $course_name)->where('status', 'published')->where('is_deleted', null)->first();
            if (!$course) {
                return redirect()->route('index');
            }
            $logged_user = auth()->user();
            $comments = Comment::where('course_id', $course->id)->where('user_id', $logged_user->id)->orderByDesc('created_at')->get();

            return view('lms::course.user-comment', compact('course', 'logged_user', 'comments'));
        } catch (\Throwable $th) {
            if (config("env.debug")) {
                dd($th->getMessage());
            } else {
                return redirect()->route('index')->with('error', config("setting.err_msg"));
            }
        }
    }

    public function commentPost(Request $request)
    {
        $request->validate([
            'course_slug' => ['required', 'max:255', new IsScriptAttack],
            'message' => 'required',
        ]);
        try {
            Comment::create(['course_id' => $request->course_slug, 'user_id' => auth()->id(), 'comment' => $request->message]);
            return back()->with('success', 'Comment posted successfully');
        } catch (\Throwable $th) {
            if (config("app.env")) {
                dd($th->getMessage());
            } else {
                return back()->with('error', config("setting.err_msg"));
            }
        }
    }

    public function commentDelete(Request $request)
    {
        Comment::where('id', $request->message_id)->delete();
        return response()->json('done', 200);
    }

    public function commentUpdate(Request $request)
    {
        try {
            $co = Comment::where('id', $request->comm_id)->first();
            if (!$co || $co->user_id != auth()->id()) {
                return response()->json('forbiden', 403);
            }
            $co->comment = $request->new_msg;
            $co->save();
            return back();
        } catch (\Throwable $th) {
            if (config("app.env")) {
                dd($th->getMessage());
            } else {
                return back();
            }
        }
    }

    public function readComments($course)
    {
        $course = Course::where('id', $course)->first();
        if (!$course) {
            return redirect()->route('dashboard');
        }
        $course_name = $course->course_title;
        $comms = Comment::where('course_id', $course->id)->get();
        return view('lms::course.course-comment', compact('comms', 'course_name'));
    }
    public function search_unenrolle(Request $request)
    {
        try {
            if ($request->q && $request->course_id) {
                $users = User::where("name", 'like', "%" . $request->q . "%")->orwhere("email", $request->q)->whereNull("is_blogger")->select('name', "id", "email")->orderByDesc('created_at')->take(10)->get();
                $data = [];
                foreach ($users as $user) {
                    array_push($data, [
                        "label" => $user->name . "  - [" . $user->email . "]",
                        "id" => $user->id,
                        "email" => $user->email,
                        "name" => $user->name
                    ]);
                }
                return response()->json(["is_success" => true, "data" => $data]);
            }
        } catch (Exception $e) {
            if (config("app.debug")) {
                dd($e->getMessage());
            } else {
                return response()->json(["is_success" => false, "message" => __("lms::messages.universal_err_msg")]);
            }
        }
    }
    public function setVidDown(Request $request, $course)
    {
        try {
            $course_id = $course;
            $course = Course::where("id", $course_id)->first();
            if (!empty($course)) {
                $set_free = !empty($request->set_free) ? 1 : 0;
                Media::where("course_id", $course_id)->update(["is_download" => $set_free]);
                $debug = "";
                if (config("app.debug")) {
                    $debug = [
                        "course_id" => $course_id,
                        "old_set_free" => $set_free
                    ];
                }
                return response()->json([
                    'success' => true,
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
}
