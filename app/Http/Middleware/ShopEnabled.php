<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ShopEnabled
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
		if(!setting('app.shop.enabled')) {
			return abort(404);
		}
        return $next($request);
    }
}
