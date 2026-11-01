<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Support\AdminJwt;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $jwt = app(AdminJwt::class);
        $admin = $jwt->authenticate($request);
        if (!$admin) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Unauthenticated.'
                ], 401);
            }
            return redirect()->route('admin.login');
        }
    
        Auth::guard('admin')->setUser($admin);
        return $next($request);
    }
}
