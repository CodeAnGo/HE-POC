<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Security\LoginAttempt;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest')->except('logout');
        $this->request = $request;
    }

    protected function redirectTo()
    {
        if (Auth::user()->getSecurityPreferences->otpLoginEnabled){
            $newLoginAttempt = LoginAttempt::create([
                'user_id' => Auth::id(),
                'ip_address' => $this->request->ip()
            ]);
            $newLoginAttempt->save();
            return route('mfa.index');
        }
        return route('dashboard.index');
    }
}
