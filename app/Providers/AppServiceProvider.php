<?php

namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer('partials.nav', 'App\Http\ViewComposers\NavigationComposer');
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
