<?php

namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Repositories\AnnotationRepository;
use App\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider {    //put your code here


    public function boot() {
        view()->composer('partials.nav', 'App\Http\ViewComposers\NavigationComposer');
        view()->composer('partials.scoreboard', 'App\Http\ViewComposers\ScoreboardComposer');
        view()->composer('contact', 'App\Http\ViewComposers\ContactComposer');
        view()->composer('stats.show', 'App\Http\ViewComposers\StatsComposer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
