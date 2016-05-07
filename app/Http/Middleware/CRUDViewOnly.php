<?php

namespace App\Http\Middleware;

use Closure;

class CRUDViewOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (request()->request->get('crud.viewOnly')) {
            abort(404);
        }
        return $next($request);
    }
}
