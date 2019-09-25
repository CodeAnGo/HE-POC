<?php

namespace App\Http\Controllers\Account;

use App\Models\Account\Profile;
use App\Traits\AutoForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountInformationController extends Controller
{
    use AutoForm;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.account.accountInformation.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->requestToORMUpdate($request);
        return redirect(route('account-information.index'));
    }
}
