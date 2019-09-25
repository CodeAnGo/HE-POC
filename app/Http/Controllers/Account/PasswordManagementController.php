<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = null;
        if ($request->session()->has('users')) {
            $status = 'true';
        }
        return view('pages.account.passwordmanagement.index', [
            'status' =>($request->session()->has('status') ? true : null)
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currentPassword' => [
                'required',
                'min:7',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Current Password isn\'t correct.');
                    }
                },
            ],
            'newPassword' => [
                'required',
                'min:7',
                'max:255',
                'confirmed'
            ],
            'newPassword_confirmation' => [
                'required',
                'min:7',
                'max:255',
            ]
        ]);
        if ($validator->fails()) {
            return redirect(route('password.index'))
                ->withErrors($validator)
                ->withInput();
        }

        Auth::user()->password = Hash::make($request->newPassword_confirmation);
        Auth::user()->save();

        return redirect(route('password.index'))->with('status', true);
    }
}
