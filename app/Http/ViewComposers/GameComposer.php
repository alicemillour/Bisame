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
class NavigationComposer {
    //put your code here
    protected $annotationRepository;

    public function __construct(AnnotationRepository $annotationRepository) {
         $this->annotationRepository = $annotationRepository;
    }
    
    public function compose(View $view) {
        if (Auth::check()){
            $cur_user = Auth::user();
            $user_id = $cur_user->id;
            $view->with('niveau', Auth::user()->level);
            $view->with('name', Auth::user()->name);
            $view->with('nb_annotations', $this->annotationRepository->get_user_annotation_count($user_id)['annotation_count']);
                        $view->with('nb_total_annotations', $this->annotationRepository->get_total_non_admin_annotations()['annotation_count']);

            $view->with('real_score', intval($this->annotationRepository->get_user_annotation_count($user_id)['annotation_count']*$cur_user->score));
        }
    }
}
