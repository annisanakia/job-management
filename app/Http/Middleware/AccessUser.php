<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AccessUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        if (!Auth::guard($guards)->check()) {
            Auth::logout();
            return redirect()->guest('login');
        }else{
            $auth = Auth::user();
            $user_id = Auth::user()->id ?? null;
            $menu_codes = allMenuSidebar() ?? [];

            $prefix = request()->route()->getPrefix() != ''? request()->route()->getPrefix() : 'home';
            if (!array_key_exists($prefix,$menu_codes) && !(in_array($prefix,['account_setting']))) {
                return response()->view('errors.unauthorized');
            }

            // $request->session()->put('job_role_ids', $job_role_ids);
        }

        return $next($request);
    }
}
