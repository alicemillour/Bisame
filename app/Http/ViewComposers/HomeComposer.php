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
use App\Repositories\CorpusRepository;
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
    protected $corpusRepository;

    public function __construct(UserRepository $userRepository, WordRepository $wordRepository, AnnotationRepository $annotationRepository, CorpusRepository $corpusRepository) {
        $this->userRepository = $userRepository;
        $this->wordRepository = $wordRepository;
        $this->annotationRepository = $annotationRepository;
        $this->corpusRepository = $corpusRepository;
    }

    public function compose(View $view) {
//        get_users_and_annotation_counts())
        $current_corpus=$this->corpusRepository->get_current_unnanotated_corpus()['id'];
        debug("current_corpus");
        debug("$current_corpus");
        debug($this->corpusRepository->get_current_unnanotated_corpus()['id']);       
        
        
        $progression = $this->annotationRepository->get_distinct_annotated_words($current_corpus)->count() * 100 / 1; //$this->annotationRepository->count_annotable_words($current_corpus)->count;
          $view
                ->with('total_sentences', $this->wordRepository->get_sentences_number($current_corpus))
                ->with('total_words', $this->wordRepository->get_words_number($current_corpus))
                ->with('progression', $progression)
                ->with('unannotated_words', $this->annotationRepository->get_unannotated_words($current_corpus))
                ->with('total_annotations_not_reference', $this->annotationRepository->get_total_annotations_not_reference()['count'])
                ->with('nb_total_users', $this->userRepository->get_users_count()['count'])
                ->with('non_admin_annotations', $this->annotationRepository->get_total_non_admin_annotations()['annotation_count'])
                ->with('participant', $this->userRepository->get_participant_count()['count'])
                ->with('registered', $this->userRepository->get_users_count()['count'])
                ->with('trained_user', $this->userRepository->get_not_training_count()['count'])
                ->with('total_distinct_words_annotated_not_ref', $this->annotationRepository->get_total_words_annotated_not_ref()['count'])
                ->with('total_phrases_non_reference', $this->annotationRepository->get_total_sentences_annotated_not_reference()['count'])
                ->with('days_of_annotation', $this->annotationRepository->get_days_of_annotation()['count'])
                ;

    }

}
