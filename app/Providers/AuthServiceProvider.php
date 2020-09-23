<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Aeronave;

use Illuminate\Contracts\Auth\Access\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Aeronave' => 'App\Policies\AeronavePolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Movimento' => 'App\Policies\MovimentoPolicy',

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(Gate $gate){
        $this->registerPolicies();

        $gate->before(function($user){
            $user->direcao == 1;
        });
    
    }
}
