<?php

namespace App\Repositories;

use App\Sentence;
use App\Word;
use App\Corpus;
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
        //getting de list of corpora ids of non deleted recipes
        $sub= Corpus::select(DB::raw("id as real_corpus_id,SUBSTRING_INDEX(name, '_', 1) as recipe_id"))
                ->where('corpora.name','rlike','[0-9]_.*');
                Log::debug("getting recipe corpora");
        Log::debug($sub->get());
        $list = DB::table(DB::raw("({$sub->toSql()}) as data"))
        ->mergeBindings($sub->getQuery())
        ->join('recipes', 'recipes.id', '=', 'recipe_id')
        ->whereNull('recipes.deleted_at')
        ->select('real_corpus_id')->pluck('real_corpus_id');
        
        Log::debug(Sentence::select('sentences.*')
                ->join('words','words.sentence_id','=','sentences.id')
                ->where('words.value', 'like', $word->value)
                ->join('corpora', 'corpus_id', '=', 'corpora.id')->whereIn('corpora.id',$list)
                ->where('corpora.name','rlike','[0-9].*')->get());
        
        return Sentence::select('sentences.*')
                ->join('words','words.sentence_id','=','sentences.id')
                ->where('words.value','like',$word->value)
                ->join('corpora', 'corpus_id', '=', 'corpora.id')->whereIn('corpora.id',$list)
                ->where('corpora.name','rlike','[0-9].*')
                ->get();
    }
}