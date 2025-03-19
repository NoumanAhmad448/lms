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

class HomeController1 extends Controller
{

public function index()
    {
        try {
            $settings = Setting::first();
            $title = __('lms::messages.site_title');
            $desc = __('lms::description.home');
            $cs = Categories::select('id', 'name', 'value')->get();
            $post = Post::where('status', 'published')->select('id', 'title', 'message', 'upload_img', 'f_name', 'slug')->orderByDesc('created_at')->first();
            $faq = Faq::where('status', 'published')->select('id', 'title', 'message', 'upload_img', 'f_name', 'slug')->orderByDesc('created_at')->first();
            $courses = Course::where('status', 'published')->whereNull('is_deleted')->with(['price:id,course_id,pricing,is_free', 'user:id,name', 'course_image'])->select('id', 'user_id', 'course_title', 'categories_selection', 'slug')->orderByDesc('created_at')->paginate(20);
            return view(config("setting.welcome_blade"), compact('title', 'desc', 'cs', 'post', 'faq', 'courses',"settings"));
        } catch (Exception $e) {
            if(config("app.debug")){
                dd($e->getMessage());
            }else{
                return back()->with('error', __("lms::messages.universal_err_msg"));
            }
        }
    }

    public function post($slug)
    {
        try {
            $title = $slug;
            $post = Post::where('slug', $slug)->first();
            if (!$post) {
                return redirect()->route('index');
            }

            $desc = substr(trim(strip_tags($post->message)), 0, 165);

            $c_img = $post->upload_img;

            $next = Post::where('status','published')->find($post->id + 1);
            $prev = Post::where('status','published')->find($post->id - 1);
            return view('lms::public_post.view_post', compact('post', 'title', 'next', 'prev', 'desc', 'c_img'));
        } catch (\Throwable $th) {
            return back()->with('error', 'server error');
        }
    }

    public function page($slug)
    {
        try {
            $title = $slug;
            $page = Page::where('slug', $slug)->first();
            if (!$page) {
                return redirect()->route('index');
            }

            $desc = "";
            switch ($slug) {
                case 'privacy-policy':
                    $desc = __('lms::description.privacy');
                    break;
                case 'terms-and-conditions':
                    $desc = __('lms::description.terms');
                    break;
                case 'about-us':
                    $desc = __('lms::description.about_us');
                    break;
            }


            return view('lms::public_post.view_page', compact('page', 'title', 'desc'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function faq($slug)
    {
        try {
            $title = $slug;
            $faq = Faq::where('slug', $slug)->first();
            if (!$faq) {
                return redirect()->route('index');
            }
            $desc = substr(trim(strip_tags($faq->message)), 0, 165);

            $c_img = $faq->upload_img;

            $next = FAQ::where('id',$faq->id + 1)->where('status','published')->first();
            $prev = FAQ::where('status','published')->find($faq->id - 1);
            return view('lms::public_post.view_faq', compact('faq', 'title', 'next', 'prev', 'desc', 'c_img'));
        } catch (\Throwable $th) {
        }
    }

    public function faqs()
    {
        try {
            $title = 'faq';
            $faqs = FAQ::where('status', 'published')->orderByDesc('created_at')->simplePaginate(15);
            return view('lms::faq', compact('title', 'faqs'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/')->with('status', 'you are logged out');
        } catch (\Throwable $th) {
            return back();
        }
    }
}