<?php

namespace App\Policies;

use App\User;
use App\Aeronave;
use Illuminate\Auth\Access\HandlesAuthorization;

class AeronavePolicy{

    use HandlesAuthorization;

    public function create(User $user){
        return $user->direcao == 1;
    }

    /**
     * Determine whether the user can update the aeronave.
     *
     * @param  \App\User  $user
     * @param  \App\Aeronave  $aeronave
     * @return mixed
     */
    public function edit(User $user, Aeronave $aeronave){
        return $user->direcao == 1;
    }
    /**
     * Determine whether the user can delete the aeronave.
     *
     * @param  \App\User  $user
     * @param  \App\Aeronave  $aeronave
     * @return mixed
     */
    public function destroy(User $user, Aeronave $aeronave){
        return $user->direcao == 1;
    }

    public function pilotos(User $user, Aeronave $aeronave){
        return $user->direcao == 1;
    }
}
