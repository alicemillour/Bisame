<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\ViewComposers;

use App\Repositories\WordRepository;
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

    public function __construct(WordRepository $wordRepository) {
        $this->wordRepository = $wordRepository;
    }

    public function compose(View $view) {
//        get_users_and_annotation_counts())
        $view->with('ref_tokens', $this->wordRepository->get_number_tokens(true)['count'])
                ->with('ref_types', $this->wordRepository->get_number_types(true)['count'])
                ->with('non_ref_tokens', $this->wordRepository->get_number_tokens(false)['count'])
                ->with('non_ref_types', $this->wordRepository->get_number_types(false)['count'])
                ->with('total_tokens', $this->wordRepository->get_total_number_tokens()['count'])
                ->with('total_types', $this->wordRepository->get_total_number_types()['count']);
    }

}
