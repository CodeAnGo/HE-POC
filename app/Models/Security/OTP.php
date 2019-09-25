<?php

namespace App\Models\Security;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use PHPGangsta_GoogleAuthenticator;

class OTP extends Model
{
    use UsesUuid;

    protected $table = 'otp';

    protected $fillable = [
        'user_id',
        'secret',
        'verified'
    ];

    public function getQRCode(){
        $ga = new PHPGangsta_GoogleAuthenticator();
        return $ga->getQRCodeGoogleUrl('CloudBurst 2FA', $this->secret, 'CloudBurst 2FA');
    }

    public function getCode(){
        $ga = new PHPGangsta_GoogleAuthenticator();
        return $ga->getCode($this->secret);
    }
}
