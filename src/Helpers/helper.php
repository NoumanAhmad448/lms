<?php

use Eren\Lms\Models\CourseStatus;
use Illuminate\Support\Facades\Auth;
use Eren\Lms\Classes\LmsCarbon;

use Eren\Lms\Notifications\SlackErrorNotification;
use Illuminate\Support\Facades\Notification;

if (! function_exists('custom_dump')) {
    function custom_dump($input): void
    {
        if (config("app.debug") && config("lms.force_debug")) {
            dump($input);
        }
    }
}

if (!function_exists('check_input')) {
    function check_input($u_input)
    {
        return htmlspecialchars(trim(stripslashes($u_input)));
    }
}


if (!function_exists('is_xss')) {
    function is_xss($u_input)
    {
        return strip_tags($u_input) != $u_input;
    }
}

if (!function_exists('reduceCharIfAv')) {
    function reduceCharIfAv($u_input, $limit)
    {
        return  strlen($u_input) > $limit ? \Illuminate\Support\Str::limit($u_input, $limit) : $u_input;
    }
}

if (!function_exists('reduceWithStripping')) {
    function reduceWithStripping($u_input, $limit)
    {
        $u_input = strip_tags($u_input);
        return  strlen($u_input) > $limit ? \Illuminate\Support\Str::limit($u_input, $limit) : $u_input;
    }
}

if (!function_exists('removeSpace')) {
    function removeSpace($input)
    {
        if (is_string($input)) {
            return  trim($input);
        }
        return $input;
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        return Auth::user()->is_admin ?? abort(403);
    }
}

if (!function_exists('allowCourseToAdmin')) {
    function allowCourseToAdmin()
    {
        return Auth::user()->is_admin ? true : false;
    }
}

if (!function_exists('showLessText')) {
    function showLessText($text, $len)
    {
        if (strlen($text) > $len) {
            return substr($text, $len);
        }
        return $text;
    }
}

if (!function_exists('changeCourseStatus')) {
    function changeCourseStatus($course_id, $val, $field_name)
    {
        $c_status = CourseStatus::where('course_id', $course_id)->first();
        if ($c_status) {
            $c_status->$field_name = $val;
            $c_status->save();
        }
    }
}
if (!function_exists('isSuperAdmin')) {

    function isSuperAdmin()
    {
        return auth()->user()->is_super_admin == 1 ?? abort(403);
    }
}
if (!function_exists('isCurrentUserAdmin')) {

    function isCurrentUserAdmin()
    {
        return auth()->user()->is_admin == 1 ? true : false;
    }
}


if (!function_exists('getAdminEmail')) {

    function getAdminEmail()
    {
        return  'admin@lms.com';
    }
}

if (!function_exists('getInsEmail')) {

    function getInsEmail()
    {
        return  'instructor@lms.com';
    }
}


if (!function_exists('getStudentEmail')) {

    function getStudentEmail()
    {
        return  'student@lms.com';
    }
}

if (!function_exists('setEmailConfigForCourse')) {

    function setEmailConfigForCourse()
    {
        config(['mail.mailers.host' => getCourseEmail()]);
        config(['mail.mailers.username' => getCourseEmail()]);
        config(['mail.mailers.password' => config("setting.no_reply_email_pass")]);
        config(['mail.from.address' => getCourseEmail()]);
    }
}
if (!function_exists('getCourseEmail')) {

    function getCourseEmail()
    {
        return  'no-reply@lms.com';
    }
}

if (!function_exists('isCurrentUserBlogger')) {

    function isCurrentUserBlogger()
    {
        return auth()->user()->is_blogger == 1 ? true : false;
    }
}

if (!function_exists('dateFormat')) {

    function dateFormat($value)
    {
        return LmsCarbon::dateFormat($value);
    }
}
if (!function_exists('dbDate')) {

    function dbDate($value)
    {
        return LmsCarbon::dbDateFormat($value);
    }
}
if (!function_exists('php_config')) {

    function php_config()
    {
        if (config("app.debug")) {
            custom_dump("memory_limit =>" . ini_get("memory_limit"));
            custom_dump("-----------------------");
            custom_dump("upload_max_filesize =>" . ini_get("upload_max_filesize"));
            custom_dump("-----------------------");
        }

        ini_set('upload_max_filesize', config("setting.memory_limit"));
        ini_set('upload_max_filesize', config("setting.upload_max_filesize"));
        set_time_limit(config("setting.set_time_limit"));
    }
}
if (!function_exists('server_logs')) {
    function server_logs(
        $e = array(),
        $request = array(),
        $config = false,
        $response_status = 500,
        $return_response = true
    ) {
        if (config("app.debug")) {
            if (count($e) > 1 && $e[0]) {
                custom_dump($e[1]->getMessage());
                custom_dump("-----------------------");
            }
            if (count($request) > 1 && $request[0]) {
                custom_dump($request[1]->all());
                custom_dump("-----------------------");
            }
            if ($config) {
                custom_dump("memory_limit" . ini_get("memory_limit"));
                custom_dump("-----------------------");
                custom_dump("upload_max_filesize=>" . ini_get("upload_max_filesize"));
                custom_dump("-----------------------");
            }
        } else if ($return_response) {
            return response()->json(['error', config("setting.err_msg"), $response_status]);
        }
    }
}


if (! function_exists('debug_logs')) {
    function debug_logs($input, $trace = false): void
    {
        if (config('app.debug')) {
            custom_dump($input);
            custom_dump(config('setting.dash_lines'));

            if ($trace) {
                debug_backtrace(2);
            }
        }
    }
}

if (! function_exists('throw_exception')) {
    function throw_exception($msg)
    {
        if (app()->environment(config("app.live_env"))) {
            Notification::route("slack", config("health.notifications.slack.webhook_url"))->notify(new SlackErrorNotification($msg));
        }
    }
}
