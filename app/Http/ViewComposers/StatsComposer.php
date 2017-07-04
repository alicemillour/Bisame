<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\ViewComposers;

use App\Repositories\WordRepository;
use App\Repositories\UserRepository;
use App\Repositories\AnnotationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Description of ScoreboardComposer
 *
 * @author alice
 */
class StatsComposer {

    //put your code here
    protected $wordRepository;
    protected $annotationRepository;
    protected $userRepository;

    public function __construct(WordRepository $wordRepository, AnnotationRepository $annotationRepository, UserRepository $userRepository) {
        $this->wordRepository = $wordRepository;
        $this->annotationRepository = $annotationRepository;
        $this->userRepository = $userRepository;
    }

    public function compose(View $view) {
//        get_users_and_annotation_counts())
        $view->with('ref_tokens', $this->wordRepository->get_number_tokens(true)['count'])
                ->with('ref_types', $this->wordRepository->get_number_types(true)['count'])
                ->with('non_ref_tokens', $this->wordRepository->get_number_tokens(false)['count'])
                ->with('non_ref_types', $this->wordRepository->get_number_types(false)['count'])
                ->with('ref_sentences', $this->wordRepository->get_number_sentences(true)['count'])
                ->with('not_ref_sentences', $this->wordRepository->get_number_sentences(false)['count'])
                ->with('total_tokens', $this->wordRepository->get_total_number_tokens()['count'])
                ->with('words_323', $this->wordRepository->get_words_number(323)['count'])
                ->with('types_323', $this->wordRepository->get_types_number(323)['count'])
                ->with('sentences_323', $this->wordRepository->get_sentences_number(323)['count'])
                ->with('days_of_annotation', $this->annotationRepository->get_days_of_annotation()['count'])
                ->with('trained_user', $this->userRepository->get_not_training_count()['count'])
                ->with('participant', $this->userRepository->get_participant_count()['count'])
                ->with('total_annotations', $this->annotationRepository->get_total_annotations()['count'])
                ->with('total_annotations_not_reference', $this->annotationRepository->get_total_annotations_not_reference()['count'])
                ->with('total_annotations_reference', $this->annotationRepository->get_total_annotations_reference()['count'])
                ->with('total_distinct_words_annotated_ref', $this->annotationRepository->get_total_words_annotated_ref()['count'])
                ->with('total_distinct_words_annotated_not_ref', $this->annotationRepository->get_total_words_annotated_not_ref()['count'])
                ->with('total_phrases_non_reference', $this->annotationRepository->get_total_sentences_annotated_not_reference()['count'])
                ->with('total_phrases_reference', $this->annotationRepository->get_total_sentences_annotated_reference()['count'])
                ->with('total_types', $this->wordRepository->get_total_number_types()['count']);
    }
}
