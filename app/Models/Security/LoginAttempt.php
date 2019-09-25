<?php

namespace App\Models\Security;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    use UsesUuid;

    protected $table = 'login_attempt';

    protected $fillable = [
        'user_id',
        'verified',
        'ip_address'
    ];
}
