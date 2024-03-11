<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GetAuthForApi
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $api_auth_token = $request->header('apiKey');
        if ($api_auth_token) {
            try {
                $user = User::where('api_auth_token', $api_auth_token)->first();
                if ($user === null) {
                    return response()->json([
                        'message' => 'no user found'
                    ], 419);
                }
                $request->user = $user;
                if(!Auth::id()){
                    auth()->login($user);
                }
                return $next($request);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'You must login first'
                ], 419);
            }
        }
        return response()->json([
            'message' => 'You must login first'
        ], 419);
    }
}
