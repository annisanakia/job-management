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
        $menus = new \Lib\core\Sidemenu();
        $menus = $menus->getAllModules();
        $menu_codes = $menus->pluck('code')->all();

        if (!Auth::guard($guards)->check()) {
            Auth::logout();
            return redirect()->guest('login');
        }else{
            $user_id = \Auth::user()->id ?? null;

            $prefix = request()->route()->getPrefix() != ''? request()->route()->getPrefix() : 'home';
            if (!in_array($prefix,$menu_codes)) {
                return response()->view('errors.unauthorized');
            }
            $job_role_ids = collect(Auth::user()->employee->employee_roles ?? [])->pluck('job_role_id')->all();
            $total_notifications = \Models\notification::select('id')
                    ->where('user_id', $user_id)
                    ->where('is_read',0)
                    ->count();

            $request->session()->put('job_role_ids', $job_role_ids);
            $request->session()->put('total_notifications', $total_notifications);
        }

        return $next($request);
    }
}
