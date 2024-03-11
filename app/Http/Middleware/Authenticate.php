<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate extends BaseMiddleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected $except = [
        'logout',
    ];

    public function handle($request, Closure $next, ...$guards)
    {
        if ($this->shouldExcludeRoute($request)) {
            return $next($request);
        }
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return $next($request);
    }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
