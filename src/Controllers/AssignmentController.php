<?php

namespace Eren\Lms\Controllers;

use Eren\Lms\Helpers\UploadData;
use Illuminate\Http\Request;
use Eren\Lms\Models\Course;
use Eren\Lms\Models\Lecture;
use Eren\Lms\Models\Assignment;
use Eren\Lms\Models\AssDescription;
use Eren\Lms\Models\AssignmentSubmition;
use Eren\Lms\Models\CourseEnrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Eren\Lms\Rules\IsScriptAttack;

class AssignmentController extends Controller
{
    protected $upload_data;

    public function __construct()
    {
        $this->upload_data = new UploadData;
    }
    public function assign(Request $request, Course $course)
    {
        try {
            $request->validate([
                'ass_title' => 'required|max:255',
                'lec_no' => 'required',
                "due_date" => "nullable"
            ]);

            $title = $request->ass_title;
            if (strip_tags($title) === $title) {

                if ($course->user_id ==  Auth::id()) {


                    $lec_no = $request->lec_no;
                    if (strip_tags($lec_no) === $lec_no) {

                        $lec = Lecture::where('lec_no', $request->lec_no)->where('course_id', $course->id)->first();
                        $id = $lec->id;
                        $course_id = $course->id;
                        $count_assign = Assignment::where('course_no', $course_id)->count();
                        $ass = new Assignment;
                        $ass->title = $title;
                        $ass->lecture_id = $id;
                        $ass->course_no = $course_id;
                        $ass_no = $count_assign ? $count_assign += 1 : '1';
                        $ass->ass_no = $ass_no;
                        if($request->due_date){
                            $ass->due_date = $request->due_date;
                        }
                        $ass->save();

                        $ass->fresh();
                        return response()->json([
                            'status' => 'Title has been saved',
                            'ass_no' => $ass_no,
                            'ass_title' => $title,
                            'ass_id' => $ass->id,
                            'title_edit' => route('update_assign', ['assign' => $ass]),
                            'delete_assign' => route('delete_assign', ['assign' => $ass]),
                            'add_ass' => route('add_ass', ['assign' => $ass]),
                            'add_assign_desc' => route('add_assign_desc', ['assign' => $ass]),
                            'add_sol' => route('add_sol', ['assign' => $ass]),

                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function update(Request $request, Assignment $assign)
    {
        try {
            $request->validate([
                'updated_title' => 'required|max:255',
            ]);

            $title = $request->updated_title;
            if (strip_tags($title) === $title) {

                if ($assign->lecture->course->user_id ==  Auth::id()) {

                    $assign->title = $title;
                    $assign->save();


                    return response()->json([
                        'status' => 'title has been updated',
                        'ass_title' => $assign->title,
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return back();
        }
    }


    public function delete(Assignment $assign)
    {

        try {
            if ($assign->lecture->course->user_id ==  Auth::id()) {

                $assign->delete();

                return back()->with('status', 'assignment has been deleted');
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function addDesc(Request $request, Assignment $assign)
    {
        try {
            if ($request->ajax()) {

                $request->validate([
                    'ass_desc_detail' => 'required|max:1000',
                ]);
                $ass_desc_detail = $request->ass_desc_detail;

                if (strip_tags($ass_desc_detail) === $ass_desc_detail) {
                    if ($assign->lecture->course->user_id ==  Auth::id()) {

                        $ass_id = $assign->id;
                        $desc = AssDescription::where('ass_id', $ass_id)->first();

                        if ($desc) {
                            $desc->description = $ass_desc_detail;
                            $desc->save();

                            return response()->json([
                                'status' => 'updated successfully',
                                'ass_desc_detail' => $ass_desc_detail
                            ], 200);
                        }
                        $desc = new AssDescription;
                        $desc->ass_id = $ass_id;
                        $desc->description = $ass_desc_detail;
                        $desc->save();

                        return response()->json([
                            'status' => 'saved successfully',
                            'ass_desc_detail' => $ass_desc_detail
                        ], 200);
                    }
                }
            }
        } catch (\Throwable $th) {
            return back();
        }
    }


    public function addAss(Request $request, Assignment $assign)
    {
        try {
            if ($request->ajax()) {

                $request->validate([
                    'upload_ot_file.*' => 'required|file|max:1000000|mimes:pdf'
                ]);

                $file = $request->file('ass_file');

                if ($assign->lecture->course->user_id != Auth::id()) {
                    abort(403);
                }

                $f_name = $file->getClientOriginalName();
                $f_mimetype = $file->getClientMimeType();

                $path = $file->store('docs', 'public');



                $assign->ass_f_path = $path;
                $assign->ass_f_name = $f_name;
                $assign->save();


                return response()->json([
                    'assign' => $assign,
                    'delete_url' => route('delete_ass_file', ['assign' => $assign]),
                    'preview_file' => route('prev_ass_file', ['file_id' => $assign])
                ]);
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function deleteFile(Assignment $assign)
    {


        try {
            if ($assign->lecture->course->user_id != Auth::id()) {
                abort(403);
            }

            $file = $assign->ass_f_path;
            if ($file) {
                $f_name = asset('vendor/lms/storage/' . $file);
                Storage::delete($f_name);
                $assign->ass_f_name = "";
                $assign->ass_f_path = "";
                $assign->save();
                return response()->json([
                    'status' => 'file has been deleted',
                ]);
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function solFileDel(Assignment $assign)
    {
        try {
            if ($assign->lecture->course->user_id != Auth::id()) {
                abort(403);
            }

            $file = $assign->ass_ans_f_path;
            if ($file) {
                $f_name = asset('vendor/lms/storage/' . $file);
                Storage::delete($f_name);
                $assign->ass_ans_f_name = "";
                $assign->ass_ans_f_path = "";
                $assign->save();
                return response()->json([
                    'status' => 'file has been deleted',
                ]);
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function addSol(Request $request, Assignment $assign)
    {
        try {
            if ($request->ajax()) {

                $request->validate([
                    'upload_ot_file.*' => 'required|file|max:1000000|mimes:pdf'
                ]);

                $file = $request->file('sol_file');

                if ($assign->lecture->course->user_id != Auth::id()) {
                    abort(403);
                }

                $f_name = $file->getClientOriginalName();

                $path = $file->store('docs', 'public');



                $assign->ass_ans_f_path = $path;
                $assign->ass_ans_f_name = $f_name;
                $assign->save();


                return response()->json([
                    'assign' => $assign,
                    'delete_url' => route('delete_sol_file', ['assign' => $assign]),
                    'preview_file' => route('prev_sola_file', ['file_id' => $assign])
                ]);
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function submit(Request $request, Assignment $assignment)
    {
        // Validate the request
        $request->validate([
            'submission_file' => 'required|file|mimes:pdf,doc,docx|max:2048',
            "course_id" => "required",
            'comments' => ['nullable', new IsScriptAttack],
        ]);

        // Check if the logged-in user is enrolled in the course
        $enrollment = CourseEnrollment::where('user_id', Auth::id())
            ->where('course_id', $request->course_id)
            ->exists();

        if (!$enrollment) {
            return response()->json(['error' => 'You are not enrolled in this course.'], 403);
        }

        // Upload the file to Amazon S3
        $file = $request->file('submission_file');
        $filePath = $this->upload_data->upload($file, $file->getClientOriginalName());

        // Check if the submission is late
        $dueDate = $assignment->due_dat ?? now();
        $isLate = Carbon::now()->greaterThan($dueDate);

        // Update the assignment record
        AssignmentSubmition::create([
            'submission_file' => $filePath,
            'student_id' => Auth()->id(),
            'is_late' => $isLate,
            "assignment_id" => $assignment->id
        ]);

        return response()->json([
            'message' => 'Assignment submitted successfully.',
            'file_path' => $filePath,
            'is_late' => $isLate,
        ],200);
    }
    public function scoreUpdate(Request $request, AssignmentSubmition $assignment)
    {
        // Validate the request
        $request->validate([
            'score' => 'required',
            'feedback' => ['nullable', new IsScriptAttack],
        ]);


        // Update the assignment record
        $assignment->update([
            'score' => $request->score,
            'feedback' => $request->feedback
        ]);

        return response()->json([
            'message' => 'Assignment Score submitted successfully.',
            'score' => $request->score,
            'feedback' => $request->feedback
        ],200);
    }
}
