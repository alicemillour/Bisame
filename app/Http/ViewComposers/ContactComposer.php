<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\ViewComposers;

use App\Repositories\AnnotationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Description of NavigationComposer
 *
 * @author alice
 */
class ContactComposer {

    public function compose(View $view) {
        if (Auth::check()){
            $cur_user = Auth::user();
            $user_id = $cur_user->id;
            $view->with('name', Auth::user()->name);
            $view->with('email', Auth::user()->email);            
        }
    }
}
