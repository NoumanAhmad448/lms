<?php

namespace Eren\Lms\Action;

use Closure;
use Eren\Lms\Models\Categories;

class CategoriesAction

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

        $categories = Categories::all();

        $data['categories'] = $categories;
        return $next($data);
    }
}
