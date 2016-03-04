<?php

namespace App\Policies;

use App\User;
use App\EveRoute;
use Illuminate\Auth\Access\HandlesAuthorization;

class EveRoutePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can load the given route.
     *
     * @param  User      $user
     * @param  EveRoute  $route
     * @return bool
     */
    public function loadwaypoints(User $user, EveRoute $route)
    {
        return $user->id === $route->user_id;
    }

    /**
     * Determine if the given user can update the given route.
     *
     * @param  User      $user
     * @param  EveRoute  $route
     * @return bool
     */
    public function update(User $user, EveRoute $route)
    {
        return $user->id === $route->user_id;
    }

    /**
     * Determine if the given user can delete the given route.
     *
     * @param  User      $user
     * @param  EveRoute  $route
     * @return bool
     */
    public function destroy(User $user, EveRoute $route)
    {
        return $user->id === $route->user_id;
    }
}
