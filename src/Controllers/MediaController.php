<?php

namespace Eren\Lms\Controllers;

use Eren\Lms\Models\Media;
use Eren\Lms\Classes\LmsCarbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MediaController extends Controller
{
    public function show()
    {
        try {
            if (isAdmin()) {
                $title = 'media';
                $media = Media::orderByDesc('created_at')->simplePaginate(15);
                return view('lms::admin.view_media', compact('title', 'media'));
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function saveAccessDuration(Request $request)
    {
        DB::table('media')->where('course_id', $request->course_id)->where('lecture_id', $request->lecture_id)->update([
            'access_duration' => $request->access_duration ? dbDate($request->access_duration): null
        ]);
        return response()->json(['message' => 'Access duration updated successfully']);
    }
}
