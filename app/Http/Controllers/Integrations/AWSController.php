<?php

namespace App\Http\Controllers\Integrations;

use App\Models\Account\User;
use App\Models\Integration\AWS;
use App\Traits\AwsHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AWSController extends Controller
{
    use AwsHelper;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $access_key_id = $request->access_key_id;
        $secret_access_key = $request->secret_access_key;

        $validator = Validator::make($request->all(), [
            'access_key_id' => [
                'required',
                'min:15',
                'max:30'
            ],
            'secret_access_key' => [
                'required',
                'min:30',
                'max:50'
            ]
        ]);
        if ($validator->fails()) {
            return redirect(route('integrations.index'))
                ->withErrors($validator)
                ->withInput();
        }

        $newAWSIntegration = AWS::create([
            'user_id' => Auth::id(),
            'access_key_id' => $request->access_key_id,
            'secret_access_key' => $request->secret_access_key
        ]);
        $newAWSIntegration->save();
        $this->listAccessKeys(Auth::user());
        return redirect(route('integrations.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->removeUsersAccessKeyFromAWS(Auth::user());
        $this->getStoredCredentialsForUser(Auth::user())->delete();
        return redirect(route('integrations.index'));
    }

    public function test(){
        return $this->describeAllInstances(Auth::user());
    }
}
