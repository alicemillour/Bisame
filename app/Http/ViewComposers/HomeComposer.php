<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\ViewComposers;

use App\Repositories\UserRepository;
use App\Repositories\WordRepository;
use App\Repositories\AnnotationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Description of ScoreboardComposer
 *
 * @author alice
 */
class HomeComposer {

    //put your code here
    protected $wordRepository;
    protected $annotationRepository;
    protected $userRepository;

    public function __construct(UserRepository $userRepository, WordRepository $wordRepository, AnnotationRepository $annotationRepository) {
        $this->userRepository = $userRepository;
        $this->wordRepository = $wordRepository;
        $this->annotationRepository = $annotationRepository;
    }

    public function compose(View $view) {
//        get_users_and_annotation_counts())
        debug($this->annotationRepository->get_unannotated_words(32));
        
     //      $progression = $this->annotationRepository->get_distinct_annotated_words(32)->count() * 100 / $this->annotationRepository->count_annotable_words(32)->count;
         $progression = 1;
        //$progression_hoch = $this->annotationRepository->get_distinct_annotated_words(325)->count() * 100 / $this->annotationRepository->count_annotable_words(325)->count;
        $progression_hoch = 1;    
        $view
                ->with('total_sentences', $this->wordRepository->get_sentences_number(32))
                ->with('total_words', $this->wordRepository->get_words_number(32))
                ->with('progression', $progression)
                ->with('unannotated_words', $this->annotationRepository->get_unannotated_words(32))                
                ->with('total_sentences_Hoch', $this->wordRepository->get_sentences_number(325))
                ->with('total_words_Hoch', $this->wordRepository->get_words_number(325))
                ->with('progression_Hoch', $progression_hoch)
                ->with('unannotated_words_Hoch', $this->annotationRepository->get_unannotated_words(325));
    }

}
