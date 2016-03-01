<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticable;

class EveUser extends Authenticable
{
    protected $fillable = ['name', 'userid', 'owner'];
}
