<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\ViewComposers;

use App\Repositories\UserRepository;
use App\Repositories\AnnotationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Description of ScoreboardComposer
 *
 * @author alice
 */
class ScoreboardComposer {

    //put your code here
    protected $userRepository;
    protected $annotationRepository;

    public function __construct(UserRepository $userRepository, AnnotationRepository $annotationRepository) {
        $this->userRepository = $userRepository;
        $this->annotationRepository = $annotationRepository;
    }

    public function compose(View $view) {
//        get_users_and_annotation_counts())
        $view->with('users_score', $this->userRepository->get_best_users_by_real_score())
                ->with('users_quantity', $this->userRepository->get_best_users_by_quantity())
                ->with('users_month', $this->userRepository->get_best_users_by_real_score_month());
    }

}
