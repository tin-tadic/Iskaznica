<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsDisabled
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

        if(auth()->user()->disabled == 0) {
            return $next($request);
        } else {
            Auth::logout();
            return redirect()->back()->with('error', 'Vaš račun je trenutno onesposobljen! Kontaktirajte administratora!');
        }

    }
}
