<?php

namespace App\Models\Preferences;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    use UsesUuid;

    protected $table = 'communication_preferences';

    protected $fillable = [
      'user_id',
      'email',
      'sms',
      'phone'
    ];
}
