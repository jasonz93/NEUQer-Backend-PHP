<?php

namespace NEUQer\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use NEUQer\User;
use NEUQer\Wx3rdMP;

class Wx3rdMPPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function owns(User $user, Wx3rdMP $mp) {
        return $mp->user->id === $user->id;
    }
}
