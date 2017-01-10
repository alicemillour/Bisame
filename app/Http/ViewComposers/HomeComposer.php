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
        debug($this->annotationRepository->get_unannotated_words(323));
        
        $progression = $this->annotationRepository->get_annotated_words(323)->count() * 100 / $this->annotationRepository->count_annotable_words(323)->count;
        
        $view
                ->with('total_sentences', $this->wordRepository->get_sentences_number(323))
                ->with('total_words', $this->wordRepository->get_words_number(323))
                ->with('progression', $progression)
                ->with('unannotated_words', $this->annotationRepository->get_unannotated_words(323));
    }

}
