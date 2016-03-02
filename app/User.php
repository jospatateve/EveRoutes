<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticable;

class User extends Authenticable
{
    protected $fillable = ['name', 'userid', 'owner'];
}
