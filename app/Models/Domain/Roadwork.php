<?php

namespace App\Models\Domain;

use Illuminate\Database\Eloquent\Model;

class Roadwork extends Model
{
    protected $fillable = [
        'eid',
        'teEventType',
        'cause',
        'long',
        'lat',
        'roadName',
        'overallStartDate',
        'overallEndDate'
    ];
}
