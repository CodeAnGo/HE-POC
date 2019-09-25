<?php

namespace App\Models\Projects;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    use UsesUuid;

    protected $fillable = [
        'user_id',
        'project_id',
        'is_owner'
    ];

    public function getUser(){
        return $this->hasOne('App\Models\Account\User');
    }

    public function getProject(){
        return $this->hasOne('App\Models\Account\User');
    }
}
