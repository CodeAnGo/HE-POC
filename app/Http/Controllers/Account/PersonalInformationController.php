<?php

namespace App\Http\Controllers\Account;

use App\Traits\AutoForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PersonalInformationController extends Controller
{
    use AutoForm;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.account.personalInformation.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $profile = $user->getProfile;

        if($request->has('pfp')){
            $pfpName = $user->id.'_pfp'.time().'.'.$request->file('pfp')->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('pfps', $request->file('pfp'), $pfpName);
            $profile->profile_picture = $pfpName;
            $profile->save();
        }

        $this->requestToORMUpdate($request);

        return redirect(route('personal-information.index'));
    }
}
