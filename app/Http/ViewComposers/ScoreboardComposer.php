<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\ViewComposers;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Description of NavigationComposer
 *
 * @author alice
 */
class ScoreboardComposer {
    //put your code here
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
         $this->userRepository = $userRepository;
    }
    
    public function compose(View $view) {
            $cur_user = Auth::user();
            $user_id = $cur_user->id;
            debug($this->userRepository->get_best_users_by_quantity());
            $view->with('users_score', $this->userRepository->get_best_users_by_score())->with('users_quantity', $this->userRepository->get_best_users_by_quantity());
    }
}
