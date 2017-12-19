<?php

namespace App\Repositories;

use App\Annotation;
use App\Word;
use App\Sentence;
use Illuminate\Support\Facades\DB;

class AnnotationRepository extends ResourceRepository {

    public function __construct(Annotation $annotation, Word $words, Sentence $sentence) {
        $this->annotation = $annotation;
        $this->words = $words;
        $this->sentence = $sentence;
    }

    private function save(Annotation $annotation, Array $inputs) {
        debug("in save annotation");
        $annotation->user_id = $inputs['user_id'];
        $annotation->postag_id = $inputs['postag_id'];
        $annotation->word_id = $inputs['word_id'];
        $annotation->confidence_score = $inputs['confidence_score'];
        $annotation->save();
    }

    public function store(Array $inputs) {
        $annotation = new $this->annotation;

        $this->save($annotation, $inputs);

        return $annotation;
    }

    public function getByWordId($word_id) {
        return $this->game->where('word_id', $word_id)->first();
    }

    public function get_number_correct_annotations_on_reference($user_id) {
        debug("in get on ref");
        return($this->annotation->select(DB::raw('count(word_id) as count'))
                        ->join('words', 'word_id', '=', 'words.id')
                        ->join('sentences', 'sentence_id', '=', 'sentences.id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                        ->whereRaw("annotations.user_id=?
                AND corpora.is_training=true
                AND (word_id, annotations.postag_id) IN 
                    (select word_id, annotations.postag_id FROM annotations, words, sentences, corpora, users
                        WHERE annotations.user_id=users.id
                        AND annotations.confidence_score=100
                        AND words.id=annotations.word_id
                        AND sentences.id=words.sentence_id
                        AND corpora.id=sentences.corpus_id
                        AND corpora.is_training=true group by word_id order by annotations.confidence_score desc)
                ", Array($user_id))
                        ->first());
    }

    public function get_number_annotations_on_reference($user_id) {
        return($this->annotation->select(DB::raw('count(word_id) as count'))
                        ->join('words', 'word_id', '=', 'words.id')
                        ->join('sentences', 'sentence_id', '=', 'sentences.id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                        ->whereRaw("annotations.user_id=?
                            AND words.id=annotations.word_id
                        AND sentences.id=words.sentence_id
                        AND corpora.id=sentences.corpus_id
                        AND corpora.is_training=true", Array($user_id))->first());
    }

    public function get_user_annotation_count($user_id) {
        /* returns number of annotations on all sentences */
        debug($this->annotation->select(DB::raw('count(*) as annotation_count'))
                        ->where('user_id', $user_id)->first());
       
        return $this->annotation->select(DB::raw('count(*) as annotation_count'))
                        ->where('user_id', $user_id)->first();
    }

    public function get_users_scores_and_annotation_counts() {
        /* returns number of annotations on all sentences */
        return $this->annotation->select(DB::raw('name, score, count(*) as annotation_count'))->get();
    }
    
    public function get_days_of_annotation() {
        /* returns number of annotations days */
        return $this->annotation->select(DB::raw('count(distinct(DATE(created_at))) as count'))->first();
    }
    
    public function get_total_non_admin_annotations() {
        return $this->annotation->select(DB::raw('count(*) as annotation_count'))
                        ->join('users', 'user_id', '=', 'users.id')
                        ->where('is_admin', false)
                        ->first();
    }

    public function get_annotated_sentences_words($user_id) {
        return $this->annotation->select(DB::raw('count(*) as annotation_count'))
                        ->where('user_id', $user_id)->first();
    }
    
    public function get_pretaggers() {
        return $this->annotation->select(DB::raw('distinct tagger'))
                ->where('tagger','not like', '')
                ->where('tagger','not like','ref')->get();
    }
    
    public function get_pretag_by_sentence_id($sentence_id) {
        /* get the names of the two pretaggers */
        $first_tagger = $this->get_pretaggers()[0]['tagger'];
        $second_tagger = $this->get_pretaggers()[1]['tagger'];
    
        $first_tags_array = $this->get_pretag_by_sentence_and_tagger($sentence_id, $first_tagger);
        $second_tags_array = $this->get_pretag_by_sentence_and_tagger($sentence_id, $second_tagger);

            
        $collection_first = collect();
        foreach ($first_tags_array as $result) {
            $collection_first->put($result->word_id, ['postag_name' => $result->postag_name, 'postag_id' => $result->postag_id]);
        }
        $first_tags = $collection_first->toArray();

        $collection_second = collect();
        foreach ($second_tags_array as $key => $result) {
            $collection_second->put($result->word_id, ['postag_name' => $result->postag_name, 'postag_id' => $result->postag_id]);
        }
        $second_tags = $collection_second->toArray();
        debug("second");
        debug($second_tags);

        $collection_pretag = collect();
        foreach ($first_tags as $key => $first_tag) {
                if ( array_key_exists($key,$second_tags) && $first_tag == $second_tags[$key]) {
                $collection_pretag->put($key, $first_tag);
                } else {
                debug("no pretag");
                $collection_pretag->put($key, null);
                }
        }
        debug($collection_pretag);
        return $collection_pretag;
    }
    
    public function get_pretag_by_sentence_and_tagger($sentence_id, $tagger_name) {
        return $this->annotation->select(DB::raw('words.id as word_id, postags.id as postag_id, postags.name as postag_name'))
                        ->join('words', 'words.id', '=', 'annotations.word_id')
                        ->join('sentences', 'sentences.id', '=', 'words.sentence_id')
                        ->join('postags', 'postags.id', '=', 'annotations.postag_id')
                        ->where('sentence_id', '=', $sentence_id)
                        ->where('annotations.tagger', 'like', $tagger_name)
                        ->get();
    }

    public function get_unannotated_words($corpus_id) {
        return $this->words->select(DB::raw('count(words.id) as count'))
                        ->join('sentences', 'sentences.id', '=', 'words.sentence_id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                        ->where('corpus_id', '=', $corpus_id)
                        ->whereNotIn('words.id', $this->get_annotated_words($corpus_id))
                        ->first();
    }

    public function get_annotated_words($corpus_id) {
        return($this->annotation->select(DB::raw('words.id'))
                        ->join('words', 'words.id', '=', 'annotations.word_id')
                        ->join('sentences', 'sentences.id', '=', 'words.sentence_id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                        ->where('annotations.confidence_score', '<', '10')
                        ->where('corpus_id', '=', $corpus_id)
//                ->where('user_id', '>', '192')
                        ->get());
    }

    public function get_distinct_annotated_words($corpus_id) {
        return($this->annotation->select(DB::raw('distinct(words.id)'))
                        ->join('words', 'words.id', '=', 'annotations.word_id')
                        ->join('sentences', 'sentences.id', '=', 'words.sentence_id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                        ->where('annotations.confidence_score', '<', '10')
                        ->where('corpus_id', '=', $corpus_id)
               # ->where('user_id', '>', '192')
                        ->get());
    }

    public function count_annotable_words($corpus_id) {
        return($this->words->select(DB::raw('count(words.id) as count'))
                        ->join('sentences', 'sentences.id', '=', 'words.sentence_id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                        ->where('corpus_id', '=', $corpus_id)
                        ->first());
    }

    public function get_total_annotations() {
        return($this->annotation->select(DB::raw('count(annotations.id) as count'))
                           ->join('words', 'words.id', '=', 'annotations.word_id')
                        ->join('sentences', 'sentences.id', '=', 'words.sentence_id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                
                        ->where('user_id', '>', 102)
                        ->where('corpora.id', '!=',324)
                        ->where('corpora.id', '!=',322)
                        ->first());
    }

        public function get_total_words_annotated_not_ref() {
        return($this->annotation->select(DB::raw('count(distinct(annotations.word_id)) as count'))
                                                ->join('words', 'words.id', '=', 'annotations.word_id')

                        ->join('sentences', 'sentences.id', '=', 'words.sentence_id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                        ->where('user_id', '>', 102)
                        ->where('corpora.id', '!=',324)
                        ->where('corpora.id', '!=',322)
                        ->where('corpora.is_training', '=', false)
                        ->first());
    }
        public function get_total_words_annotated_ref() {
        return($this->annotation->select(DB::raw('count(distinct(annotations.word_id)) as count'))
                                        ->join('words', 'words.id', '=', 'annotations.word_id')

                        ->join('sentences', 'sentences.id', '=', 'words.sentence_id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                        ->where('user_id', '>', 102)
                        ->where('corpora.id', '!=',324)
                        ->where('corpora.id', '!=',322)
                        ->where('corpora.is_training', '=', true)
                        ->first());
    }
    
    public function get_total_annotations_not_reference() {
        return($this->annotation->select(DB::raw('count(annotations.id) as count'))
                        ->join('words', 'words.id', '=', 'annotations.word_id')
                        ->join('sentences', 'sentences.id', '=', 'words.sentence_id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                        ->where('user_id', '>', 102)
                        ->where('corpora.is_training', '=', false)
                        ->where('corpora.id', '!=',324)
                        ->where('corpora.id', '!=',322)
                        ->first());
    }
        public function get_total_annotations_reference() {
        return($this->annotation->select(DB::raw('count(annotations.id) as count'))
                        ->join('words', 'words.id', '=', 'annotations.word_id')
                        ->join('sentences', 'sentences.id', '=', 'words.sentence_id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                        ->where('user_id', '>', 102)
                        ->where('corpora.is_training', '=', true)
                        ->where('corpora.id', '!=',324)
                        ->where('corpora.id', '!=',322)
                        ->first());
    }

    public function get_total_sentences_annotated_not_reference() {
        return($this->sentence->select(DB::raw('count(distinct(sentences.id)) as count'))
                        ->join('words', 'words.sentence_id', '=', 'sentences.id')
                        ->join('annotations', 'annotations.word_id', '=', 'words.id')
                        ->join('corpora', 'corpora.id', '=', 'corpus_id')
                        ->where('user_id', '>', 102)
                        ->where('corpora.is_training', '=', false)
                        ->first());
    }
    public function get_total_sentences_annotated_reference() {
        return($this->sentence->select(DB::raw('count(distinct(sentences.id)) as count'))
                        ->join('words', 'words.sentence_id', '=', 'sentences.id')
                        ->join('annotations', 'annotations.word_id', '=', 'words.id')
                        ->join('corpora', 'corpora.id', '=', 'corpus_id')
                        ->where('user_id', '>', 102)
                        ->where('corpora.is_training', '=', true)
                        ->first());
    }

}
