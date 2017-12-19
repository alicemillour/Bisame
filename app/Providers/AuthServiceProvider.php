<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Game' => 'App\Policies\GamePolicy',
        'App\Training' => 'App\Policies\TrainingPolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Recipe' => 'App\Policies\RecipePolicy',        
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
