<?php

namespace App\Repositories;

use App\Sentence;
use App\Word;
use DB;
use Log;

class SentenceRepository extends ResourceRepository
{

    //protected $user;

    public function __construct(Sentence $sentence)
    {
		$this->sentence = $sentence;
    }

    public function all()
    {
            return $this->sentence->all();
    }
        
    public function getWordNotPunctCount($sentence_id)
    {
        return Sentence::join('words','sentence_id','=','sentences.id')
                ->select(DB::raw('count(*) as word_not_punct_count, value'))
                ->where('sentence_id',$sentence_id)
                ->whereRaw("value NOT REGEXP '^([[:punct:]]|„|“)$'")->first();
    }    
    public function getWords($sentence_id)
    {
        return Sentence::select('words.id')
                ->join('words','words.sentence_id','=','sentences.id')
                ->where('sentence_id',$sentence_id)->toArray();
    }
    
    public function getSentencesFromWordValue($word)
    {
        Log::debug(Sentence::select('sentences.*')
                ->join('words','words.sentence_id','=','sentences.id')
                ->where('words.value', 'like', $word->value)
                ->join('corpora', 'corpus_id', '=', 'corpora.id')
                ->where('corpora.name','rlike','[0-9].*')->get());
        
        return Sentence::select('sentences.*')
                ->join('words','words.sentence_id','=','sentences.id')
                ->where('words.value','like',$word->value)
                ->join('corpora', 'corpus_id', '=', 'corpora.id')
                ->where('corpora.name','rlike','[0-9].*')
                ->get();
    }
}