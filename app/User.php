<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticable;

use App\EveRoutes;

class User extends Authenticable
{
    protected $fillable = ['name', 'userid', 'owner'];

    public function everoutes()
    {
        return $this->hasMany(EveRoute::class);
    }
}
