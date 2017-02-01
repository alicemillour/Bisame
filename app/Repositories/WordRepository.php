<?php

namespace App\Repositories;

use App\Models\Word;
use App\Models\Sentence;
use Illuminate\Support\Facades\DB;

class WordRepository extends ResourceRepository {

    public function __construct(Word $word,Sentence $sentence) {
        $this->word = $word;
        $this->sentence = $sentence;
    }

    public function getByWordId($word_id) {
        return $this->game->where('word_id', $word_id)->first();
    }

    public function get_number_tokens($corpus_is_training) {
        return($this->word->select(DB::raw('count(words.id) as count'))
                        ->join('sentences', 'sentence_id', '=', 'sentences.id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                        ->where('corpora.is_training','=',$corpus_is_training)
                
                        ->where('corpora.id', '!=',324)
                        ->where('corpora.id', '!=',322)
                
                ->first());
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
    public function get_words_number($corpus_id) {
        return($this->word->select(DB::raw('count(words.id) as count'))
                ->join('sentences', 'sentence_id', '=', 'sentences.id')
                ->join('corpora', 'corpus_id', '=', 'corpora.id')
                ->where('corpora.id','=',$corpus_id)->first());
    }
    public function get_types_number($corpus_id) {
        return($this->word->select(DB::raw('count(distinct(words.value)) as count'))
                ->join('sentences', 'sentence_id', '=', 'sentences.id')
                ->join('corpora', 'corpus_id', '=', 'corpora.id')
                ->where('corpora.id','=',$corpus_id)->first());
    }
    public function get_sentences_number($corpus_id) {
        return($this->sentence->select(DB::raw('count(sentences.id) as count'))
                ->join('corpora', 'corpus_id', '=', 'corpora.id')
                ->where('corpora.id','=',$corpus_id)->first());
    }
}
