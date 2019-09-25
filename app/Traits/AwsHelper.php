<?php


namespace App\Traits;


use App\Models\Account\User;
use App\Models\Integration\AWS;
use App\Traits\AWS\EC2;
use App\Traits\AWS\IAM;
use Aws\Credentials\Credentials;
use Aws\Exception\AwsException;
use Aws\Exception\CredentialsException;
use Aws\Iam\IamClient;
use Illuminate\Support\Facades\Auth;

trait AwsHelper
{
    use IAM;
    use EC2;

    private function validateUser(User $user){
        if ($user == null) {
            $user = Auth::user();
        }
        return $user;
    }
}
