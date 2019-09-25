<?php


namespace App\Traits;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


trait AutoForm
{
    public function requestToORMUpdate(Request $request){
        $user = $request->user();
        $profile = $user->getProfile;
        $communicationPreferences = $user->getCommunicationPreferences;
        $securityPreferences = $user->getSecurityPreferences;

        foreach ($request->all() as $key=>$value){
            $value = $this->checkboxToBool($value);
            switch ($key){
                case in_array($key, $profile->getFillable()):
                    $profile->$key = $value;
                    $profile->save();
                    break;
                case in_array($key, $communicationPreferences->getFillable()):
                    $communicationPreferences->$key = $value;
                    $communicationPreferences->save();
                    break;
                case in_array($key, $securityPreferences->getFillable()):
                    $securityPreferences->$key = $value;
                    $securityPreferences->save();
                    break;
            }
        }
    }

    private function checkboxToBool($value){
        if ($value == 'on'){
            return true;
        } else if ($value == 'off'){
            return false;
        } else {
            return $value;
        }
    }
}
