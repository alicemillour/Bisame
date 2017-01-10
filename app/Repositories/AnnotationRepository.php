<?php

namespace App\Repositories;

use App\Models\Annotation;
use App\Models\Word;
use Illuminate\Support\Facades\DB;

class AnnotationRepository extends ResourceRepository {

    public function __construct(Annotation $annotation, Word $words) {
        $this->annotation = $annotation;
        $this->words = $words;
    }

    private function save(Annotation $annotation, Array $inputs) {
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
        return($this->annotation->select(DB::raw('count(word_id) as count'))
                        ->join('words', 'word_id', '=', 'words.id')
                        ->join('sentences', 'sentence_id', '=', 'sentences.id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                        ->whereRaw("annotations.user_id=?
                AND corpora.is_training=true
                AND (word_id, annotations.postag_id) IN 
                    (select word_id, annotations.postag_id FROM annotations, words, sentences, corpora, users
                        WHERE annotations.user_id=users.id
                        AND users.id=92
                        AND words.id=annotations.word_id
                        AND sentences.id=words.sentence_id
                        AND corpora.id=sentences.corpus_id
                        AND corpora.is_training=true group by word_id order by annotations.confidence_score desc)
                ", Array($user_id))
                        ->first());
    }

    public function get_number_annotations_on_reference($user_id) {
        /* */
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
        return $this->annotation->select(DB::raw('count(*) as annotation_count'))
                        ->where('user_id', $user_id)->first();
    }

    public function get_users_scores_and_annotation_counts() {
        /* returns number of annotations on all sentences */
        return $this->annotation->select(DB::raw('name, score, count(*) as annotation_count'))->get();
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

    public function get_pretag_by_sentence_id($sentence_id) {
        $melt_tags_array = $this->get_pretag_by_sentence_and_tagger($sentence_id, "MElt");
        $treetagger_tags_array = $this->get_pretag_by_sentence_and_tagger($sentence_id, "TreeTagger");

        $collection_melt = collect();
        foreach ($melt_tags_array as $result) {
            $collection_melt->put($result->word_id, $result->postag_id);
        }
        $melt_tags = $collection_melt->toArray();

        $collection_tt = collect();
        foreach ($treetagger_tags_array as $result) {
            $collection_tt->put($result->word_id, $result->postag_id);
        }
        $treetagger_tags = $collection_tt->toArray();

        $collection_pretag = collect();
        foreach ($melt_tags as $key => $melt_tag) {
//            debug($key);
            if ($melt_tag == $treetagger_tags[$key]) {
                $collection_pretag->put($key, $melt_tag);
            } else {
                $collection_pretag->put($key, null);
            }
        }
//        debug($collection_pretag[89808]);
        return $collection_pretag;
    }

    public function get_pretag_by_sentence_and_tagger($sentence_id, $tagger_name) {
        return $this->annotation->select(DB::raw('words.id as word_id, postags.name as postag_id'))
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
    
    public function count_annotable_words($corpus_id) {
        return($this->words->select(DB::raw('count(words.id) as count'))
                ->join('sentences', 'sentences.id', '=', 'words.sentence_id')
                ->join('corpora', 'corpus_id', '=', 'corpora.id')
                ->where('corpus_id', '=', $corpus_id)
                ->first());
    }

}
