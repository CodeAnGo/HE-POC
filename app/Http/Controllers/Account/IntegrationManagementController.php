<?php

namespace App\Http\Controllers\Account;

use App\Models\Account\User;
use App\Models\Integration\AWS;
use App\Traits\AwsHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IntegrationManagementController extends Controller
{
    use AwsHelper;

    private function awsDataBuilder(){
        if (AWS::where('user_id', Auth::id())->count() == 0){
            $access_key_id = null;
            $access_key_last_used = null;
        } else {
            $access_key_id = $this->getAccessKeyIdFromUser(Auth::user());
            $access_key_last_used = $this->checkWhenUsersCredentialWasLastUsed(Auth::user());
        }
        return [
            'credentials' => [
                'access_key_id' => $access_key_id,
                'last_used' => $access_key_last_used
            ]
        ];
    }
    private function gcpDataBuilder(){
        return [

        ];
    }
    private function azureDataBuilder(){
        return [

        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.account.intergrationmanagement.index',[
            'aws' => $this->awsDataBuilder(),
            'gcp' => $this->gcpDataBuilder(),
            'azure' => $this->azureDataBuilder(),
        ]);
    }
}
