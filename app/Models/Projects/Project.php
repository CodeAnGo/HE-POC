<?php

namespace App\Models\Projects;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use UsesUuid;

    protected $fillable = [
        'name',
        'description',
        'paragraph',
        'logo',
        'cloud'
    ];
}
