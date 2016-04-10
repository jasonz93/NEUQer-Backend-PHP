<?php

namespace NEUQer\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use NEUQer\CETAdmission;
use NEUQer\SigninAdmission;
use NEUQer\User;

class SigninPolicy
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

    public function check(User $user, SigninAdmission $admission) {
        return $admission->user_id === $user->id;
    }
}
