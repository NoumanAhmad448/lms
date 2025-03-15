<?php

namespace Eren\Lms\Controllers;

use Eren\Lms\Helpers\UploadData;
use Illuminate\Http\Request;
use Eren\Lms\Http\Requests\PostRequest;
use Eren\Lms\Models\Post;
use Eren\Lms\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Cocur\Slugify\Slugify;
use Eren\lms\Rules\DuplicateTitle;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

class BloggerPostController extends Controller
{
    protected $uploadData;

    public function __construct()
    {
        $this->uploadData = new UploadData;
    }
    public function view()
    {
        try {
            $setting = Setting::select('isBlog', 'isFaq')->first();
            if ($setting->isBlog) {
                $posts = Post::orderByDesc('created_at')->simplePaginate(10);
                $title = "posts";
                return view('lms::bloggers.view_post', compact('title', 'posts', 'setting'));
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function createPost()
    {
        try {
            $setting = Setting::select('isBlog')->first();
            if ($setting->isBlog) {

                $title = "create_post";
                return view('lms::bloggers.index', compact('title', 'setting'));
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function savePost(Request $request)
    {
        $permission = Setting::select('isBlog')->first();
        if ($permission->isBlog) {

            $request->validate([
                'title' => ['required', 'max:1000', new DuplicateTitle],
                'message' => ['required'],
                'upload_img' => 'required|image|mimes:jpeg,png,jpg|max:5000',
            ]);
        }
        try {
            if ($permission->isBlog) {

                $data = $request->only(['title', 'message']);
                $img = $request->upload_img;
                $f_name = $img->getClientOriginalName();

                $path = $this->uploadData->upload($img, $f_name);
                $data['f_name'] =  $f_name;
                $data['upload_img'] = $path;

                $user = Auth::user();
                $u_name = $user->name;
                $u_email = $user->email;

                $data['slug'] = (new Slugify)->slugify($request->title);

                $data['name'] =  $u_name;
                $data['email'] = $u_email;
                $data['status'] = "unpublished";

                Post::create($data);


                return redirect()->route('blogger_v_p')->with('status', 'post has been saved');
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            if (config("app.debug")) {
                dd($th->getMessage());
            } else {
                return back()->with('error', 'unable to process the request');
            }
        }
    }
    public function changeStatus(Post $post)
    {
        try {
            $permission = Setting::select('isBlog')->first();
            if ($permission->isBlog) {

                $status = $post->status;

                if ($status == "unpublished") {
                    $post->status = "published";
                } else {
                    $post->status = "unpublished";
                }
                $post->save();

                return redirect()->route('blogger_v_p')->with('status', 'post status has changed');
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function delete(PostRequest $request, Post $post)
    {
        try {
            $request->validated();
            $img = $post->upload_img ?? '';
            if ($img) {
                $path = public_path('storage/' . $img);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $post->delete();
            return back()->with('status', 'Post has been deleted');
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function editPost(Post $post)
    {
        try {
            $setting = Setting::select('isBlog')->first();
            if ($setting->isBlog) {
                $title = "e_post";
                return view('lms::bloggers.edit-post', compact('title', 'post', 'setting'));
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            if (config("app.debug")) {
                dd($th->getMessage());
            } else {
                return back();
            }
        }
    }

    public function updatePost(Request $request, Post $post)
    {
        try {
            $permission = Setting::select('isBlog')->first();
            if ($permission->isBlog) {
                $request->validate([
                    'title' => ['required', 'max:1000'],
                    'message' => 'required',
                    'upload_img' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
                ]);

                $data = $request->only(['title', 'message']);
                $img = $request->upload_img;
                if ($img) {
                    $f_name = $img->getClientOriginalName();
                    $path = $this->uploadData->upload($img, $f_name);
                    $data['f_name'] =  $f_name;
                    $data['upload_img'] = $path;
                }

                $user = Auth::user();
                $u_name = $user->name;
                $u_email = $user->email;
                $data['slug'] = (new Slugify)->slugify($request->title);
                $data['name'] =  $u_name;
                $data['email'] = $u_email;


                Post::where('id', $post->id)->update($data);


                return back()->with('status', 'Post has been updated');
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            if (config("app.debug")) {
                dd($th->getMessage());
            } else {
                return back();
            }
        }
    }
}
