<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Request;


class ApiVersion
{
    protected $apiKey;
    protected $apiValue;

    public function __construct(Request $request)
    {
//        $this->apiKey = explode('=',$request->header('api_version'))[0];
//        $this->apiValue = explode('=',$request->header('api_version'))[1];
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        if ($request->header('api_version') && in_array( $this->apiValue, config('api.versions.'. $this->apiKey))) {
//            return $next($request);
//        } else {
//            return response()->json('Non valid api version', 422);
//        }
        if ($request->header('api_version') && in_array( $request->header('api_version'), config('api.versions'))) {
            return $next($request);
        } else {
            return response()->json('Non valid api version', 422);
        }

    }
}
