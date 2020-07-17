<?php

namespace App\Http\Middleware;

use App\User;
use Auth;
use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::find(Auth::id());
        if($user->role_users()->first()->name === "Admin"){
            return $next($request);
        }
        return abort(403,'anda bukan admin');
    }
}
