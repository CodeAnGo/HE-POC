<?php

namespace App\Http\Controllers\Auth;

use App\Models\Security\LoginAttempt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MFACheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.mfa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->otpCode == Auth::user()->getOTP->getCode()){
            $loginAttemptsFromThisIP = LoginAttempt::where('user_id', Auth::id())->where('verified', false)->where('ip_address', $request->ip())->get();
            foreach ($loginAttemptsFromThisIP as $loginAttempt){
                $loginAttempt->verified = true;
                $loginAttempt->save();
            }
            return redirect(route('dashboard.index'));
        } else {
            $validator = Validator::make($request->all(), [
                'otpCode' => [
                    'required',
                    'numeric',
                    'min:6',
                    function ($attribute, $value, $fail) {
                        if ($value != Auth::user()->getOTP->getCode()) {
                            $fail('2FA Passcode isn\'t correct.');
                        }
                    },
                ]
            ]);
            if ($validator->fails()) {
                return redirect(route('mfa.index'))
                    ->withErrors($validator);
            }
        }
    }
}
