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
        debug($this->annotationRepository->get_unannotated_words(326));
        
        
        $progression = $this->annotationRepository->get_distinct_annotated_words(326)->count() * 100 / $this->annotationRepository->count_annotable_words(326)->count;
        // $progression = 1;
        //$progression = $this->annotationRepository->get_distinct_annotated_words(326)->count() * 100 / $this->annotationRepository->count_annotable_words(326)->count;
        debug("progression $progression");
        //$progression_hoch = $this->annotationRepository->get_distinct_annotated_words(325)->count() * 100 / $this->annotationRepository->count_annotable_words(325)->count;
//        $progression_hoch = 1;    
        $view
                ->with('total_sentences', $this->wordRepository->get_sentences_number(326))
                ->with('total_words', $this->wordRepository->get_words_number(326))
                ->with('progression', $progression)

                ->with('unannotated_words', $this->annotationRepository->get_unannotated_words(326))                
//                ->with('total_sentences_Hoch', $this->wordRepository->get_sentences_number(325))
//                ->with('total_words_Hoch', $this->wordRepository->get_words_number(325))
//                ->with('progression_Hoch', $progression_hoch)
//                ->with('unannotated_words_Hoch', $this->annotationRepository->get_unannotated_words(325))
                ->with('total_annotations_not_reference', $this->annotationRepository->get_total_annotations_not_reference()['count'])
                ->with('unannotated_words_Hoch', $this->annotationRepository->get_unannotated_words(325))
                ->with('nb_total_users', $this->userRepository->get_user_count()['count'])
                ->with('non_admin_annotations', $this->annotationRepository->get_total_non_admin_annotations()['annotation_count'])
                ->with('participant', $this->userRepository->get_participant_count()['count'])
                ->with('registered', $this->userRepository->get_user_count()['count'])
                ->with('trained_user', $this->userRepository->get_not_training_count()['count'])
                ->with('total_distinct_words_annotated_not_ref', $this->annotationRepository->get_total_words_annotated_not_ref()['count'])
                ->with('total_phrases_non_reference', $this->annotationRepository->get_total_sentences_annotated_not_reference()['count'])
                ->with('days_of_annotation', $this->annotationRepository->get_days_of_annotation()['count'])
                ;

    }

}
