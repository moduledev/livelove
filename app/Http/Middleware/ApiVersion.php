<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Request;


class ApiVersion
{
    protected $apiValue;

    public function __construct(Request $request)
    {
       $this->apiValue = str_replace('application/json;v=','',$request->header('content-type'));
    }

    /**
     * Check is api version valid.
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('content-type') && in_array( $this->apiValue, config('api.versions'))) {
            return $next($request);
        } else {
            return response()->json('Non valid api version', 422);
        }

    }
}
