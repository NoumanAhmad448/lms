<?php

namespace Eren\Lms\Action;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CreateInstructorAction
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

        if (!Auth::user()?->is_instructor) {
            $user = User::findOrFail(Auth::id());
            if ($user) {
                $user->is_instructor = 1;
                $user->save();
            }
        }
        return $next($data);
    }
}
