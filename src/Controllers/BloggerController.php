<?php

namespace Eren\Lms\Controllers;

use Eren\Lms\Http\Requests\AdminRequest;
use Eren\Lms\Http\Requests\BloggerRequest;
use Eren\Lms\Http\Requests\UpdateBloggerProfile;
use Eren\Lms\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BloggerController extends Controller
{
    public function show()
    {
        try {
            $title = 'bloggers';
            $users = User::select('id', 'name', 'email')->where('is_blogger', 1)->orderByDesc('created_at')->get(15);
            return view('lms::admin.bloggers', compact('title', 'users'));
        } catch (\Throwable $th) {
            return back();
        }
    }


    public function store_blogger(BloggerRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            $data['email'] = $data['email'] . "@lms.com";
            $data['email_verified_at'] = now();
            $data['is_blogger'] = 1;
            User::create($data);
            return redirect()->route('show_blogger___')->with('status', "Account has been created");
        } catch (Exception $e) {
            return back()->with('error', 'server error');
        }
    }

    public function edit($user)
    {
        try {
            $user = User::select('id', 'name', 'email')->where('id', $user)->first();
            $title = 'edit_blogger';
            return view('lms::admin.edit-blogger', compact('title', 'user'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function updateBlogger(UpdateBloggerProfile $request, User $user)
    {

        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            $data['email'] = $data['email'] . "@lms.com";
            $user->update($data);
            return redirect()->route('show_blogger___')->with('status', "Account has been updated");
        } catch (Exception $e) {
            return back()->with('error', 'server error');
        }
    }
    public function delete(User $user)
    {
        try {
            if (isAdmin()) {
                $user->delete();
                return back()->with('status', 'user has deleted');
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function index()
    {
        try {
            $title = trans('messages.blogger_login');
            return view('lms::bloggers.index', compact('title'));
        } catch (\Throwable $th) {
            return back();
        }
    }


    public function login(AdminRequest $request)
    {
        try {
            $request->validated();

            $credentials =  $request->only('email');
            $credentials['is_blogger'] = 1;

            $user = User::where($credentials)->first();
            if ($user) {
                $password = $request->password;

                if (Hash::check($password, $user->password)) {
                    $request->session()->regenerate();
                    Auth::login($user);
                    return redirect()->route('blogger_home');
                } else {
                    return back()->withErrors([
                        'password' => 'The provided password is wrong',
                    ]);
                }
            }
            return back()->withErrors([
                'email' => 'The provided credentials are wrong',
            ]);
        } catch (Exception $e) {
            return back()->with('error', 'server error. Please try again');
        }
    }
}
