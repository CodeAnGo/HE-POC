<?php

namespace App\Http\Middleware;

use App\Models\Security\LoginAttempt;
use Closure;
use Illuminate\Support\Facades\Auth;

class MFACheck
{
    protected $except = [
        '/otp/*'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $usersLoginAttempt = LoginAttempt::where('user_id', Auth::id())
            ->where('ip_address', $request->ip())
            ->where('verified', false)
            ->get();

        if (count($usersLoginAttempt) > 0){
            return redirect(route('mfa.index'));
        }
        return $next($request);
    }
}
