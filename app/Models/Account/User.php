<?php

namespace App\Models\Account;

use App\Models\Concerns\UsesUuid;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getInitials(){
        $initials = '';
        foreach (mb_split(' ', $this->name) as  $index=>$str){
            if ($index > 2){
                break;
            }
            elseif (strlen($str) > 1){
                $initials = $initials . $str[0];
            }
        }
        return $initials;
    }

    public function getProfile(){
        return $this->hasOne('App\Models\Account\Profile');
    }

    public function getCommunicationPreferences(){
        return $this->hasOne('App\Models\Preferences\Communication');
    }

    public function getSecurityPreferences(){
        return $this->hasOne('App\Models\Preferences\Security');
    }

    public function getProfilePicture(){
        return env('APP_URL') . '/storage/pfps/' . ($this->getProfile->profile_picture);
    }

    public function getOTP(){
        return $this->hasOne('App\Models\Security\OTP');
    }

    public function getLoginAttempts(){
        return $this->hasMany('App\Models\Security\LoginAttempt');
    }

    public function getProjectMembership(){
        return $this->hasManyThrough('App\Models\Projects\Project',  'App\Models\Projects\ProjectMember');
    }
}
