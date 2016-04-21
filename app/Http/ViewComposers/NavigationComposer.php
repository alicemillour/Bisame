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

    public function __construct(AnnotationRepository $annotationRepository) {
         $this->annotationRepository = $annotationRepository;
    }
    
    public function compose(View $view) {
        if (Auth::check()){
            $user_id =  Auth::user()->id;
            $view->with('niveau', Auth::user()->level);
            $view->with('name', Auth::user()->name);
            $view->with('nb_annotations', $this->annotationRepository->getScore($user_id)['annotation_count']);
        }
    }
}
