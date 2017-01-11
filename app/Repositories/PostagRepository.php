<?php

namespace App\Repositories;

use App\Models\Postag;
use App\Models\Annotation;
use DB;

class PostagRepository extends ResourceRepository {

    //protected $user;

    public function __construct(Postag $postag) {
        $this->postag = $postag;
    }

    public function getById($id) {
        return $this->postag->findOrFail($id);
    }

    public function all() {
        return $this->postag->all();
    }

    public function count() {
        return $this->postag->count();
    }

    public function getPostagsForWordId($word_id) {
        $postags = $this->getDatabaseRequestPostagsForWordId($word_id)->get();
        if (count($postags) < 1) {
            /* si on n'a pas de préannotation */
            return $this->GetPostagsExceptPunct()->all();
        } elseif (count($postags) == 1) {
            $first_postag = $this->getDatabaseRequestPostagsForWordId($word_id)->first();
            /* get second random postag */
            $complementary = $this->GetComplementaryRandomPostags($first_postag)->random(1);
            $postags->push($complementary);
        }

        /* generate random proposition 1 on 10 cases */
        if (rand(0, 10) == 7) {
            /* TODO : CHANGE NEXT LINE */
            return $this->sortPostagsByName($postags)->values()->all();
//        $this->getTwoDifferentPostags($postags);
        } else {
            // If un des postags est AUX rajouter VERB et CONJ rajouter SCONJ
            debug($this->sortPostagsByName($postags)->values()->all());
            return $this->sortPostagsByName($postags)->values()->all();
        }
    }

    private function GetComplementaryRandomPostags($postag) {
        return (Postag::select('postags.*')
                        ->where('id', '!=', $postag['id'])->where('name', 'NOT LIKE', "PUNCT")->get());
    }

    private function GetPostagsExceptPunct() {
        return Postag::select('postags.*')->where('name', 'NOT LIKE', "PUNCT")->get();
    }

    public function getReferenceForWordId($word_id) {
        $annotations = Annotation::join('postags', 'postags.id', '=', 'annotations.postag_id')
                ->select(DB::raw('postag_id as id, name, full_name, description'))
                ->distinct()
                ->where('word_id', $word_id)
                ->where('confidence_score', '=','100')->first();
        return $annotations;
    }

    private function getDatabaseRequestPostagsForWordId($word_id) {
        /* get existing annotation for word_id */
        $annotations = Annotation::join('postags', 'postags.id', '=', 'annotations.postag_id')
                ->select(DB::raw('postag_id as id, name, full_name, description'))
                ->distinct()
                ->where('word_id', $word_id)
                ->orderBy('confidence_score', 'desc');
        return $annotations;
    }

    private function sortPostagsByName($postags) {
        return $postags->sortBy(function($postags) {
                    return $postags->name;
                });
    }

}
