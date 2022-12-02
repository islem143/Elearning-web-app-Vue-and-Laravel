<?php

namespace App\Http\Middleware;

use App\Models\Log;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityMiddleware
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
        if (auth("sanctum")->check()) {
            $user = auth("sanctum")->user();
            Log::create([
                "user_id" => $user->id,
                "user_name" => $user->name,
                "role" => $user->getRoleNames()[0]
            ]);
        }
        return $next($request);
    }
}
