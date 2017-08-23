<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\ViewComposers;

use App\Repositories\AnnotationRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Description of NavigationComposer
 *
 * @author alice
 */
class NavigationComposer {

    //put your code here
    protected $annotationRepository;
    protected $userRepository;

    public function __construct(AnnotationRepository $annotationRepository, UserRepository $userRepository) {
        $this->annotationRepository = $annotationRepository;
        $this->userRepository = $userRepository;
    }

    public function compose(View $view) {
        if (Auth::check()) {
            $cur_user = Auth::user();
            $user_id = $cur_user->id;
//            debug($this->annotationRepository->get_total_non_admin_annotations()['annotation_count']);
            $view->with('niveau', Auth::user()->level);
            $view->with('name', Auth::user()->name);
            $view->with('non_admin_annotations', $this->annotationRepository->get_total_non_admin_annotations()['annotation_count']);
            $view->with('nb_annotations', $this->annotationRepository->get_user_annotation_count($user_id)['annotation_count']);
            $view->with('nb_total_users', $this->userRepository->get_participant_count()['count']);
            debug("valeurs de score dans la navbar");
            debug($this->annotationRepository->get_user_annotation_count($user_id)['annotation_count']);
            debug($cur_user->score);
            $view->with('real_score', intval($this->annotationRepository->get_user_annotation_count($user_id)['annotation_count'] * $cur_user->score));
        } else {
//            debug($this->annotationRepository->get_total_non_admin_annotations()['annotation_count']);
            $view->with('non_admin_annotations', $this->annotationRepository->get_total_non_admin_annotations()['annotation_count']);
            $view->with('nb_total_users', $this->userRepository->get_user_count()['count']);
        }
    }

}
