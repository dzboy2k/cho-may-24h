<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuthTokenMiddleware extends BaseMiddleware
{
    protected $except = [
        'logout'
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->shouldExcludeRoute($request)) {
            return $next($request);
        }
        if (Auth::check()) {
            if (!Auth::user()->api_auth_token) {
                Auth::logout();
                return redirect()->route('home')->with('message', ['content' => __('message.expire_login_session'), 'type' => 'error']);
            }
        }
        return $next($request);
    }
}
