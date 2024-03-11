<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CassoEventAuthMiddleware extends BaseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($this->shouldExcludeRoute($request)) {
            return $next($request);
        }
        if ($request->header('Secure-Token') != env(config('constants.CASSO_KEY_NAME'))) {
            return response()->json(['message' => 'Secure token not match'], 401);
        }
        return $next($request);
    }
}
