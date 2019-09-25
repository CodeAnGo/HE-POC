<?php

namespace App\Models\Integration;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class AWS extends Model
{
    use UsesUuid;

    protected $table = 'aws_integrations';

    protected $fillable = [
        'user_id',
        'access_key_id',
        'secret_access_key'
    ];
}
