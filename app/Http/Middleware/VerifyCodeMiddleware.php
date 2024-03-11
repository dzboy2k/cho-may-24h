<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VerifyCodeMiddleware extends BaseMiddleware
{
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
        $canVerify = true;
        if (!$request->token || !$request->email) {
            $canVerify = false;
        }
        if (!Hash::check(base64_decode($request->email), $request->token)) {
            $canVerify = false;
        }

        if (!$canVerify) {
            return redirect()->route('auth.forgot_password')->with('message', ['content' => __('auth.not_allow_page'), 'type' => 'error']);
        }
        return $next($request);
    }
}
