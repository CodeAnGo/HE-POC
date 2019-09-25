<?php


namespace App\Traits\AWS;


use App\Models\Account\User;
use Aws\Ec2\Ec2Client;
use Illuminate\Support\Facades\Auth;

trait EC2
{
    private function EC2Factory(User $user, $region='eu-west-1', $version='2016-11-15'){
        return new Ec2Client([
            'region' => $region,
            'version' => $version,
            'credentials' => $this->getCredentials($user),
        ]);
    }

    public function describeAllInstances(User $user){
        $EC2Client = $this->EC2Factory($user);
        return $EC2Client->describeInstances();
    }
}
