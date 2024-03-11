<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BaseMiddleware
{
    /**
     * Routes that should skip handle.
     *
     * @var array
     */
    protected $except = [];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    protected function shouldExcludeRoute($request)
    {
        $current_path = $request->path();
        return in_array($current_path, $this->except);
    }
}
