<?php

namespace App\Models\Preferences;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
    use UsesUuid;

    protected $table = 'security_preferences';

    protected $fillable = [
        'user_id',
        'securedPasswordReset',
        'otpLoginEnabled'
    ];
}
