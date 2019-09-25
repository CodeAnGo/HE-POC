<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OTPController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->OTPCode == Auth::user()->getOTP->getCode()){
            $otp = Auth::user()->getOTP;
            $otp->verified = true;
            $otp->save();
            $securityPreferences = Auth::user()->getSecurityPreferences;
            $securityPreferences->otpLoginEnabled = true;
            $securityPreferences->save();
            return redirect(route('account-information.index'));
        } else {
            $validator = Validator::make($request->all(), [
                'OTPCode' => [
                    'required',
                    'min:6',
                    'max:6',
                    function ($attribute, $value, $fail) {
                        if ($value != Auth::user()->getOTP->getCode()) {
                            $fail('2FA Passcode isn\'t correct.');
                        }
                    },
                ]
            ]);
            if ($validator->fails()) {
                return redirect(route('account-information.index'))
                    ->withErrors($validator);
            }
        }
    }
}
