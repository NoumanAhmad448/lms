<?php

namespace Eren\Lms\Action;

use Closure;
use Eren\Lms\Models\Course;
use Illuminate\Support\Facades\Auth;

class CoursesAction
{

    protected $uploadData;

    public function __construct() {}

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  callable  $next
     * @return mixed
     */
    public function handle($data, Closure $next)
    {

        $courses = Course::with(['course_image'])->where('user_id', Auth::id())->whereNull('is_deleted')
            ->select('id', 'user_id', 'course_title', 'status', 'slug', 'updated_at')->orderByDesc('created_at')->simplePaginate();
        $data['courses'] = $courses;
        return $next($data);
    }
}
