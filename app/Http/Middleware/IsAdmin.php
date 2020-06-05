<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        if (Auth::check()) {
            $auth = auth()->user()->roles()->select('name')->first();
            if ($auth->name === 'admin' ) {
                return $next($request);
            }
            return redirect()->route('home');
        }
        return redirect()->route('login');
    }
}
