<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsPublished
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
		if(!setting('app.published') && !$request->user()) {
			return response(view('errors.unpublished'));
		}
        return $next($request);
    }
}
