<?php

namespace NEUQer\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use NEUQer\CETAdmission;
use NEUQer\User;

class CETPolicy
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

    public function owns(User $user, CETAdmission $admission) {
        return $admission->user_id === $user->id;
    }
}
