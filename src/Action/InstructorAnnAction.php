<?php

namespace Eren\Lms\Action;

use Closure;
use Eren\Lms\Models\InstructorAnn;

class InstructorAnnAction
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

        $ann = InstructorAnn::orderByDesc('created_at')->simplePaginate(3);
        $data['ann'] = $ann;
        return $next($data);
    }
}
