<?php

namespace App\Http\Middleware;

use Closure;

class ApiVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ($request->header('api_version') && in_array( $request->header('api-version'), config('api.versions.users'))) {
            return $next($request);
        } else {
            return response()->json('Non validated api version', 422);
        }

    }
}
