<?php


namespace App\Traits\AWS;


use App\Models\Account\User;
use App\Models\Integration\AWS;
use Aws\Credentials\Credentials;
use Aws\Exception\AwsException;
use Aws\Iam\IamClient;
use Illuminate\Support\Facades\Auth;

trait IAM
{
    private function validateUser(User $user){
        if ($user == null) {
            $user = Auth::user();
        }
        return $user;
    }

    private function getStoredCredentialsForUser(User $user){
        return AWS::where('user_id', $user->id)->first();
    }

    private function getAccessKeyIdFromUser(User $user){
        if(AWS::where('user_id', $user->id)->count() == 0){
            return null;
        } else {
            return AWS::where('user_id', $user->id)->first()->access_key_id;
        }
    }

    private function getCredentials(User $user){
        $awsCredentials = $this->getStoredCredentialsForUser($user);
        return new Credentials($awsCredentials->access_key_id, $awsCredentials->secret_access_key);
    }

    private function IAMFactory(User $user, $region='eu-west-1', $version='2010-05-08'){
        return new IamClient([
            'region' => $region,
            'version' => $version,
            'credentials' => $this->getCredentials($user),
        ]);
    }

    public function checkCredentialsValid(User $user){
        $user = $this->validateUser($user);
        $IAMClient = $this->IAMFactory($user);
        try{
            $IAMClient->getAccessKeyLastUsed([
                'AccessKeyId' => $this->getStoredCredentialsForUser($user)->access_key_id
            ]);
            return true;
        } catch (AwsException $exception){
            return false;
        }
    }

    public function checkWhenUsersCredentialWasLastUsed(User $user){
        $user = $this->validateUser($user);
        $IAMClient = $this->IAMFactory($user);
        try{
            $last_used = $IAMClient->getAccessKeyLastUsed([
                'AccessKeyId' => $this->getStoredCredentialsForUser($user)->access_key_id
            ]);
            return $last_used;
        } catch (AwsException $exception){
            return null;
        }
    }

    public function removeUsersAccessKeyFromAWS(User $user){
        $user = $this->validateUser($user);
        $IAMClient = $this->IAMFactory($user);
        try{
            $IAMClient->deleteAccessKey([
                'AccessKeyId' => $this->getStoredCredentialsForUser($user)->access_key_id
            ]);
            return true;
        } catch (AwsException $exception){
            return false;
        }
    }

    public function listAccessKeys(User $user){
        $user = $this->validateUser($user);
        $IAMClient = $this->IAMFactory($user);
        try{
            $access_keys = $IAMClient->listAccessKeys();
            return $access_keys;
        } catch (AwsException $exception){
            return null;
        }
    }
}
