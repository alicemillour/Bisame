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
 * Description of WordcloudComposer
 *
 * @author alice
 */
class WordcloudComposer {

    //put your code here
    protected $wordRepository;

    public function __construct(WordRepository $wordRepository) {
        $this->wordRepository = $wordRepository;
    }
    public function compose(View $view) {
//        get_users_and_annotation_counts())
        $view->with('random50words', $this->wordRepository->get_50words_in_recipes());


    }

}
