<?php

namespace App\Repositories;

use App\Models\Sentence;
use App\Models\Word;
use DB;

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

}