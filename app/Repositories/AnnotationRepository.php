<?php

namespace App\Repositories;

use App\Models\Annotation;
use Illuminate\Support\Facades\DB;

class AnnotationRepository extends ResourceRepository
{


    public function __construct(Annotation $annotation)
	{
		$this->annotation = $annotation;
	}
    private function save(Annotation $annotation, Array $inputs)
	{
		$annotation->user_id = $inputs['user_id'];	
		$annotation->postag_id = $inputs['postag_id'];
		$annotation->word_id = $inputs['word_id'];
		$annotation->confidence_score = $inputs['confidence_score'];	
		$annotation->save();
	}

	public function store(Array $inputs)
	{
		$annotation = new $this->annotation;		

		$this->save($annotation, $inputs);

		return $annotation;
	}

	public function getByWordId($word_id)
	{
		return $this->game->where('word_id', $word_id)->first();
	}
        
        public function get_number_correct_annotations($user_id)
	{
            return($this->annotation->select(DB::raw('count(word_id) as count'))
                ->join('words','word_id', '=', 'words.id')
                ->join('sentences','sentence_id', '=', 'sentences.id')
                ->join('corpora','corpus_id', '=', 'corpora.id')
                ->whereRaw("annotations.user_id=?
                AND corpora.is_training=true
                AND (word_id, annotations.postag_id) IN 
                    (select word_id, annotations.postag_id FROM annotations, words, sentences, corpora, users
                        WHERE annotations.user_id=users.id
                        AND users.name=\"admin\"
                        AND words.id=annotations.word_id
                        AND sentences.id=words.sentence_id
                        AND corpora.id=sentences.corpus_id
                        AND corpora.is_training=true group by word_id)
                ",Array($user_id))
                 ->first());
        }
        
        public function get_user_annotation_count($user_id)
	{
            /* returns user score in confidence % */
            return $this->annotation->select(DB::raw('count(*) as annotation_count'))
                ->where('user_id', $user_id)->first();
        }
        
        public function get_total_non_admin_annotations()
	{
             return $this->annotation->select(DB::raw('count(*) as annotation_count'))
                    ->join('users','user_id', '=', 'users.id')
                    ->where('is_admin', false)
                    ->first();
        }
        
        public function get_annotated_sentences_words($user_id)
	{
            return $this->annotation->select(DB::raw('count(*) as annotation_count'))
                ->where('user_id', $user_id)->first();
        }
}