<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\ViewComposers;

use App\Repositories\AnnotationRepository;
use App\Repositories\UserRepository;
use App\Repositories\WordRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use DB;
use App\Recipe;
use App\Word;
use App\AnnotatedRecipe;
use App\AlternativeText;

/**
 * Description of NavigationComposer
 *
 * @author alice
 */
class NavigationComposer {

    //put your code here
    protected $annotationRepository;
    protected $userRepository;
    protected $wordRepository;

    public function __construct(AnnotationRepository $annotationRepository, UserRepository $userRepository, Word $words, WordRepository $wordRepository) {
        $this->annotationRepository = $annotationRepository;
        $this->userRepository = $userRepository;
        $this->wordRepository = $wordRepository;
        $this->words = $words;
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
            $view->with('nb_annotations_user', $this->annotationRepository->get_user_annotation_count_on_recipe($user_id)['0']->annotation_count);
            $view->with('nb_total_users', $this->userRepository->get_users_count()['count']);
            $view->with('real_score', intval($this->annotationRepository->get_user_annotation_count($user_id)['annotation_count'] * $cur_user->score));
            $view->with('nb_recipes_user', $this->userRepository->get_recipe_number_by_user($user_id)['count']);
            $view->with('nb_variantes_user', $this->userRepository->get_variant_number_by_user($user_id)['count']+$this->userRepository->get_word_variant_number_by_user($user_id)['count']);
        } else {
//            debug($this->annotationRepository->get_total_non_admin_annotations()['annotation_count']);
            $view->with('non_admin_annotations', $this->annotationRepository->get_total_non_admin_annotations()['annotation_count']);
            $view->with('nb_total_users', $this->userRepository->get_users_count()['count']);
        }
        $view->with('nb_recipes', Recipe::count());
        $view->with('nb_words', $this->wordRepository->get_distinct_word_in_recipes());
        $view->with('nb_recipe_words_annotated', DB::select(DB::raw('SELECT count(words.id) as count from words, sentences, corpora, annotated_recipes where corpora.name like concat(annotated_recipes.recipe_id, "_%") and 
words.sentence_id=sentences.id and sentences.corpus_id=corpora.id;'))['0']->count);
        $view->with('nb_recipe_annotations', DB::select(DB::raw('SELECT count(annotations.id) as count from annotations where annotations.tagger like ""'))['0']->count);
        $view->with('nb_recipe_versions', AlternativeText::count());
//                        ->from('annotated_recipes')
//                        ->join('sentences', 'sentences.id', '=', 'words.sentence_id')
//                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
//                        ->whereRaw('corpora.name like concat(annotated_recipes.recipe_id, "_%")')
//                        ->get());
//            'nb_variantes' => Recipe::latest()->with('author')->withCount('likes')->orderBy(DB::Raw('annotated+validated'), 'desc')->limit(3)->get(),
    }

}
