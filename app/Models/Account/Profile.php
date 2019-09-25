<?php

namespace App\Models\Account;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use UsesUuid;

    protected $fillable = [
        'user_id',
        'profile_picture',
        'phone_number',
        'addr1',
        'addr2',
        'addr3',
        'postcode',
        'country',
        'timezone',
        'title',
        'verified'
    ];

    public function getProfilePicture(){
        return $this->profile_picture;
    }

    public function getUser(){
        return $this->belongsTo('App\Models\Account\User', 'user_id', 'id');
    }
}
