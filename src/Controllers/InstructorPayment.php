<?php

namespace Eren\Lms\Controllers;

use Eren\Lms\Http\Requests\CreateNotificationRequest;
use Eren\Lms\Models\CourseHistory;
use Eren\Lms\Models\InstructorAnn;
use Eren\Lms\Models\InstructorEarning;
use Eren\Lms\Models\InstructorPayment as ModelsInstructorPayment;
use Eren\Lms\Models\MonthlyPaymentModel;
use Eren\Lms\Models\User;
use Eren\Lms\Classes\LmsCarbon;
use Exception;
use Illuminate\Support\Facades\DB;

class InstructorPayment extends Controller
{
    public function viewPayment()
    {
        try {
            // dd('testing');
            $title = "i_payment";
            $users = User::select('name', 'email', 'id')->where('is_instructor', 1)->where('is_admin', null)->where('is_blogger', null)->where('is_super_admin', null)->get();
            return view('lms::admin.i_payment', ['title' => $title, 'users' => $users]);
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function viewInstructorDetail(User $user)
    {
        try {
            if (isAdmin()) {
                $title = 'view_i_detail';
                $payment_detail = ModelsInstructorPayment::where('user_id', $user->id)->first();
                $total_earning = InstructorEarning::where('ins_id', $user->id)->sum('earning');

                $current_month_earning = InstructorEarning::where('ins_id', $user->id)->whereYear('created_at', LmsCarbon:now()->year)->whereMonth('created_at', LmsCarbon:now()->month)->sum('earning');

                $prev_month = LmsCarbon::currentMonth() - 1;
                $cu_year = LmsCarbon::currentYear();
                $payment = [];

                $payment_history = [];
                for ($prev_month; $prev_month > 0; $prev_month--) {
                    $cure_mon_income = InstructorEarning::whereMonth('created_at', $prev_month)->whereYear('created_at', $cu_year)->where('ins_id', $user->id)->sum('earning');
                    $payment[$prev_month] = $cure_mon_income;

                    $m_payment = MonthlyPaymentModel::where('month', $prev_month)->where('user_id', (int)$user->id)->whereYear(
                        'created_at',
                        LmsCarbon:now()->year
                    )->value('payment');



                    $payment_history[$prev_month] = $m_payment;
                }




                return view('lms::admin.monthly_detail', compact(
                    'title',
                    'user',
                    'payment_detail',
                    'payment',
                    'payment_history',
                    'total_earning',
                    'current_month_earning'
                ));
            }
        } catch (\Throwable $th) {
            return back()->with('error', 'error');
        }
    }

    public function createInfo()
    {
        try {
            $title = "i_ann";
            return view('lms::admin.i_ann', compact('title'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function showInfo()
    {
        try {
            $title = "i_ann";
            $instructors = DB::table('instructor_anns')->select('message', 'id')->orderByDesc('instructor_anns.message')->get();
            return view('lms::admin.s_ann', compact('title', 'instructors'));
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function postInfo(CreateNotificationRequest $request)
    {
        try {
            $request->validated();
            if (isAdmin()) {
                $message = $request->message;
                if (isset($message) && $message) {
                    $admin = new InstructorAnn;
                    $admin->message = $message;
                    $admin->save();
                    return redirect()->route('s_info')->with('status', "your message has saved");
                }
            }
        } catch (Exception $e) {
            return back()->with('error', 'we could not save it. Please try again');
        }
    }

    public function showEdit($i)
    {
        try {
            $title = "i_ann";
            $instructor = DB::table('instructor_anns')->select('message', 'id')->where('id', $i)->get();

            return view('lms::admin.show_edit_ann', compact('title', 'instructor'));
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function edit(CreateNotificationRequest $request, InstructorAnn $i)
    {
        try {
            $request->validated();
            $i->message = $request->message;
            $i->save();
            return back()->with('status', 'updated');
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function delete(InstructorAnn $i)
    {
        try {
            if (isAdmin()) {
                $i->delete();
                return response()->json('successful');
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function paymentHistory()
    {
        try {
            if (isAdmin()) {
                $title = "payment history";
                $course_history = CourseHistory::select('id', 'course_id', 'ins_id', 'user_id', 'amount', 'pay_method', 'created_at')->orderByDesc('created_at')->get();
                if ($course_history) {
                    $course_history->load(['course:id,course_title', 'ins:id,name', 'user:id,name']);
                }
                return view('lms::admin.payment_history', compact('title', 'course_history'));
            }
        } catch (\Throwable $th) {
            if (isAdmin()) {
                $title = "payment history";
                $course_history = CourseHistory::select('id', 'course_id', 'ins_id', 'user_id', 'amount', 'pay_method', 'created_at')->orderByDesc('created_at')->get();
                if ($course_history) {
                    $course_history->load(['course:id,course_title', 'ins:id,name', 'user:id,name']);
                }
                return view('lms::admin.payment_history', compact('title', 'course_history'));
            }
        }
    }
}
