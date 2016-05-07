<?php

namespace App\Http\Middleware;

use Closure;

class CRUDHasManyObjects
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
        $values = request()->request->get('crud.hasManyObjects');
        if ($values) {
            view()->share('hasManyObjects', $values);
        }
        return $next($request);
    }
}
