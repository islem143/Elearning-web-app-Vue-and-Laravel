<?php

namespace App\Http\Middleware;

use App\Models\Role as RoleMod;
use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {   dd("s");
        $rolesMap = [
            "admin" => RoleMod::IS_ADMIN,
            "delevery" => RoleMod::IS_TEACHER,
            "client" => RoleMod::IS_STUDENT
        ];
        if (!Auth::check()) {
            return Response(["message" => "access denied"], 403);
        }

        if ($request->user()->role_id == RoleMod::IS_ADMIN) {
            return $next($request);
        }


        foreach ($roles as $role) {

            if (!($request->user()->role_id == $rolesMap[$role])) {
                return Response(["message" => "access denied"], 403);
            }
            return $next($request);
        }
    }
}
