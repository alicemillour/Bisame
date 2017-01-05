<?php

namespace App\Repositories;

use App\Models\Word;
use Illuminate\Support\Facades\DB;

class WordRepository extends ResourceRepository {

    public function __construct(Word $word) {
        $this->word = $word;
    }

    public function getByWordId($word_id) {
        return $this->game->where('word_id', $word_id)->first();
    }

    public function get_number_tokens($corpus_is_training) {
        return($this->word->select(DB::raw('count(words.id) as count'))
                        ->join('sentences', 'sentence_id', '=', 'sentences.id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                        ->where('corpora.is_training','=',$corpus_is_training)->first());
    }
    
    public function get_number_types($corpus_is_training) {
        return($this->word->select(DB::raw('count(distinct(value)) as count'))
                        ->join('sentences', 'sentence_id', '=', 'sentences.id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                        ->where('corpora.is_training','=',$corpus_is_training)->first());
    }
    public function get_total_number_tokens() {
        return($this->word->select(DB::raw('count(words.id) as count'))->first());
    }
    
    public function get_total_number_types() {
        return($this->word->select(DB::raw('count(distinct(value)) as count'))->first());
    }
}
