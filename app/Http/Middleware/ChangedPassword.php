<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ChangedPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->password_changed == 1) {
            return $next($request);
        } else {
            return redirect()->route('editUser', auth()->user()->id)->with('error', 'Morate promijeniti šifru prije nastavka rada!');
        }
    }
}
