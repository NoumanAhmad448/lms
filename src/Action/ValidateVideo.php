<?php

namespace Eren\Lms\Action;


class ValidateVideo
{

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  callable  $next
     * @return mixed
     */
    public function handle($request, $next)
    {

        $request->validate([
            'upload_video' => 'required|max:4500000|mimetypes:video/mp4,video/webm,video/ogg'
        ]);

        return $next($request);
    }
}
