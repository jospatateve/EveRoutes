<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EveSystem extends Model
{
    protected $fillable = [
        'name',
        'system_id',
        'security_status',
        'security_class',
        'neighbours'
    ];
}
