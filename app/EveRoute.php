<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class EveRoute extends Model
{
    protected $fillable = ['name', 'waypoints'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
