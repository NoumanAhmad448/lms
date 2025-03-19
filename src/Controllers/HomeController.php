<?php

namespace Eren\Lms\Controllers;

use Eren\Lms\Http\Requests\ContactUsRequest;
use App\Mail\ContactUsMail;
use Eren\Lms\Models\Categories;
use Eren\Lms\Models\Course;
use Eren\Lms\Models\Faq;
use Eren\Lms\Models\Post;
use Eren\Lms\Models\Page;
use Eren\Lms\Models\R;
use Eren\Lms\Models\u;
use Eren\Lms\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Eren\Lms\Models\Article;
use Eren\Lms\Models\RatingModal;
use Eren\Lms\Models\Setting;

class HomeController extends Controller
{

    public function posts()
    {
        try {
            $title = __('lms::messages.post');
            $desc = __('lms::description.posts');
            $posts = Post::where('status', 'published')->orderByDesc('created_at')->simplePaginate(15);
            return view('lms::public_post.posts', compact('title', 'posts', 'desc'));
        } catch (Exception $th) {
        }
    }

    public function contactUs()
    {
        try {
            $title = "contact us";
            $desc = __('lms::description.contact_us');

            return view('lms::xuesheng.contact-us', compact('title', 'desc'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function contactUsPost(ContactUsRequest $request)
    {
        try {

            $request->validated();
            // dd($request->all());
            Mail::to(config("mail.contact_us_email"))->queue(new ContactUsMail(
                $request->name,
                $request->email,
                $request->mobile ?? '',
                $request->country ?? '',
                $request->subject,
                $request->body
            ));

            return back()->with('status', 'Your Message has delivered. We will contact you soon');
        } catch (\Exception $e) {
            return back()->with('error', 'your message was not delievered. Please try again');
        }
    }

    public function upload(Request $request)
    {
        try {
            if ($request->hasFile('upload')) {
                $originName = $request->file('upload')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('upload')->getClientOriginalExtension();
                $fileName = $fileName . '_' . time() . '.' . $extension;

                $request->file('upload')->move(public_path('images'), $fileName);

                $CKEditorFuncNum = $request->input('CKEditorFuncNum');
                $url = asset('vendor/lms/images/' . $fileName);
                $msg = 'Image uploaded successfully';
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

                @header('Content-type: text/html; charset=utf-8');
                echo $response;
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function getSearch(Request $request)
    {

        try {
            $q = $request->q;
            $ex = '%' . $q . '%';
            $res = DB::table('courses')->whereNull('is_deleted')->where('course_title', 'like', $ex)->orWhere('categories_selection', 'like', $ex)->orWhere('c_level', 'like', $ex)
                ->where('status', 'published')->select('course_title')->orderByDesc('created_at')->take(10)->get();
            $data = [];
            if ($res && $res->count()) {
                foreach ($res as $s) {
                    array_push($data, $s->course_title);
                }
            } else {
                $users = User::where('name', 'like', "%" . $q . "%")->select('name')->orderByDesc('created_at')->take(10)->get();
                if ($users->count()) {
                    foreach ($users as $user) {
                        array_push($data, $user->name);
                    }
                }
            }
            return response()->json($data);
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function userSearch(Request $request)
    {
        try {
            $searched_keyword = $request->search_course;
            if (!$searched_keyword) {
                return back();
            }

            return redirect()->route('s-search-page', ['keyword' => $searched_keyword]);
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function showSearchCourse($keyword)
    {
        try {
            if (!$keyword) {
                return back();
            } else if (is_xss($keyword)) {
                abort(403);
            }

            $title = $keyword;
            $courses = Course::where('course_title', 'like', '%' . $keyword . '%')->where('status', 'published')
                ->whereNull('is_deleted')
                ->orderByDesc('created_at')->simplePaginate(15);

            if (is_null($courses)) {
                $user = User::where('name', $keyword)->select('id')->first();
                if (! is_null($user) && $user?->count()) {
                    $courses = Course::where('user_id', $user->id)->whereNull('is_deleted')
                    ->where('status', 'published')->
                    orderByDesc('created_at')->simplePaginate(15);
                }
            }
            return view('lms::xuesheng.show-course', compact('title', 'courses', 'keyword'));
        } catch (\Throwable $th) {
            debug_logs($th->getMessage());
            return redirect()->route('index');
        }
    }

}
