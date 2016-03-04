<?php

namespace App\EveOnline;

use App\User;

class EveUserFactory
{
    public static function create($userinfo)
    {
        $user = new User;
        $user->userid = $userinfo->getCharacterId();
        $user->name = $userinfo->getCharacterName();
        $user->owner = $userinfo->getCharacterOwnerHash();
        $user->save();
        return $user;
    }

    public static function reset(User $user, $userinfo)
    {
        $user->delete();
        return static::create($userinfo);
    }
}
