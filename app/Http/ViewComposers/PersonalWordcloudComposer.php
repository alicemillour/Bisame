<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\ViewComposers;

use App\Repositories\UserRepository;
use App\Repositories\WordRepository;
use App\Word;
use App\Repositories\AnnotationRepository;
use App\Repositories\CorpusRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Collection;
//use Illuminate\Database\Eloquent\Collection;
use Log;

/**
 * Description of WordcloudComposer
 *
 * @author alice
 */
class PersonalWordcloudComposer {

    //put your code here
    protected $wordRepository;

    public function __construct(WordRepository $wordRepository) {
        $this->wordRepository = $wordRepository;
    }
    
    public function cast($obj, $to_class) {
        if(class_exists($to_class)) {
            $obj_in = serialize($obj);
            $obj_out = 'O:' . strlen($to_class) . ':"' . $to_class . '":' . substr($obj_in, $obj_in[2] + 7);
            return unserialize($obj_out);
        }
        else {
            return false;
        }
    }
    
    public function compose(View $view) {
//        get_users_and_annotation_counts())
        if (Auth::check()) {
            $cur_user = Auth::user();
            $user_id = $cur_user->id;
            $random50words=$this->wordRepository->get_50words_in_recipes();
            $personal_words=$this->wordRepository->get_words_in_recipes_by_user($user_id);

              Log::debug(get_class($personal_words));

            $view->with('personal_words', $personal_words);

        } else {
            $view->with('personal_words', null);
        }
    }
}
