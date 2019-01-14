<?php

namespace App\Repositories;

use App\Word;
use App\Corpus;
use Log;
use App\Sentence;
use Illuminate\Support\Facades\DB;
use \App\AlternativeText;
use \App\AlternativeWord;

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
                ->first());
    }
    
    public function get_number_types($corpus_is_training) {
        return($this->word->select(DB::raw('count(distinct(value)) as count'))
                        ->join('sentences', 'sentence_id', '=', 'sentences.id')
                        ->join('corpora', 'corpus_id', '=', 'corpora.id')
                        ->where('corpora.is_training','=',$corpus_is_training)->first());
    }
    public function get_number_sentences($corpus_is_training) {
        return($this->word->select(DB::raw('count(distinct(sentences.id)) as count'))
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
    
    public function get_50words_in_recipes(){
        return($this->word->select('words.*')
                ->join('sentences', 'sentence_id', '=', 'sentences.id')
                ->join('corpora', 'corpus_id', '=', 'corpora.id')
                ->whereRaw("value NOT REGEXP '^([[:punct:]]|„|“|\\\*)$'")
                ->orderBy(DB::raw('RAND()'))
                ->where('corpora.name','rlike','[0-9].*')->take(150)->get());
    }
    
    public function get_words_in_recipes_by_user($user_id){
        $sub= Corpus::select(DB::raw("id as real_corpus_id,SUBSTRING_INDEX(name, '_', 1) as custom_corpus_id"))
                ->where('corpora.name','rlike','[0-9]_.*');
        Log::debug("getting recipe corpora");
        Log::debug($sub->get());
        
        $data = DB::table(DB::raw("({$sub->toSql()}) as data"))
        ->mergeBindings($sub->getQuery())
        ->join('recipes', 'recipes.id', '=', 'custom_corpus_id')
        ->join('sentences', 'corpus_id', '=', 'real_corpus_id')
        ->join("users", 'recipes.user_id', '=', 'users.id')
        ->join("words", 'sentences.id', '=', 'sentence_id')
        ->where("user_id", '=', $user_id)
        ->whereNull('recipes.deleted_at')
        ->select(DB::raw('words.id as ids'))
        ->pluck('ids')  
        ->groupBy('value')    
        ->take(150);
        
        Log::debug("getting words for user");     
        Log::debug($data);
        
        if ($data->first() != null) {
            Log::debug("data is not null");
            $list=$data->first()->shuffle();
            Log::debug($list);     
            $words=Word::whereIn('id', $list)->orderBy(DB::raw('RAND()'))->get();
            Log::debug("words to appear in personal cloud");
            Log::debug(get_class($words));
            Log::debug($words);
            return($words);
        } else {
            Log::debug("No words for current user");
            return(null);
        } 
    }
    
    public function get_word_count_by_value($value){
        return($this->word->select('words.*')
                ->join('sentences', 'words.sentence_id', '=', 'sentences.id')
                ->join('corpora', 'corpus_id', '=', 'corpora.id')
                ->where('words.value', 'like', $value)
                ->where('corpora.name','rlike','[0-9].*')->get()->count());
    }
    
    public function get_word_cats_by_value($value){
        Log::debug($this->word->select(DB::raw('postags.id as postag_id, sentences.id as sentence_id, postags.full_name as postag_full_name, annotations.tagger as tagger'))
                ->join('sentences', 'words.sentence_id', '=', 'sentences.id')
                ->join('corpora', 'corpus_id', '=', 'corpora.id')
                ->join('annotations', 'words.id', '=', 'annotations.word_id')
                ->join('postags', 'annotations.postag_id', '=', 'postags.id')
                ->where('words.value', 'like', $value)
                ->where('corpora.name','rlike','[0-9].*')
                ->groupBy('postag_id')
                ->get());
        
        return($this->word->select(DB::raw('postags.id as postag_id, users.name as user_name, sentences.id as sentence_id, postags.full_name as postag_full_name, annotations.tagger as tagger'))
                ->join('sentences', 'words.sentence_id', '=', 'sentences.id')
                ->join('corpora', 'corpus_id', '=', 'corpora.id')
                ->join('annotations', 'words.id', '=', 'annotations.word_id')
                ->join('postags', 'annotations.postag_id', '=', 'postags.id')
                ->join('users', 'users.id', '=', 'annotations.user_id')
                ->where('words.value', 'like', $value)
                ->where('corpora.name','rlike','[0-9].*')
                ->groupBy('user_id')
                ->get());
    }
    
    public function get_distinct_word_in_recipes(){
        return($this->word->select('words.*')
                ->join('sentences', 'words.sentence_id', '=', 'sentences.id')
                ->join('corpora', 'corpus_id', '=', 'corpora.id')
                ->where('corpora.name','rlike','[0-9].*')->count());
    }

    public function get_word_variants_by_value($value){
        $sub_recipe=AlternativeText::select(DB::raw("users.name as user_name, value as value,translatable_id, offset_start as off_start,offset_end as off_end"))
                ->join("users", 'user_id', '=', 'users.id')
                ->where("translatable_type", 'rlike', '.*Recipe')
                ->where('translatable_attribute', 'like', 'content');
        $sub_title=AlternativeText::select(DB::raw("users.name as user_name, value as value,translatable_id, offset_start as off_start,offset_end as off_end"))
                ->join("users", 'user_id', '=', 'users.id')
                ->where("translatable_type", 'rlike', '.*Recipe')
                ->where('translatable_attribute', 'like', 'title');
        $sub_ingredient=AlternativeText::select(DB::raw("users.name as user_name, value as value,translatable_id, offset_start as off_start,offset_end as off_end"))
                ->join("users", 'user_id', '=', 'users.id')
                ->where("translatable_type", 'rlike', '.Ingredient');
        $sub_word_variant=AlternativeWord::select(DB::raw("users.name as user_name, original as original, alternative as variant"))
                ->join("users", 'user_id', '=', 'users.id')
                ->where("original", 'like', $value)->get();
        Log::debug("word variant");
        Log::debug($sub_word_variant);
        $content_recipe = DB::table(DB::raw("({$sub_recipe->toSql()}) as data"))
        ->mergeBindings($sub_recipe->getQuery()) // you need to get underlying Query Builder
        ->leftJoin(DB::raw("recipes AS rcps"), 'rcps.id', '=', 'data.translatable_id')
        ->whereNotNull('deleted_at')
        ->select(DB::raw("user_name, TRIM(TRAILING '.' FROM TRIM(TRAILING ',' FROM TRIM(TRAILING ' ' FROM substring("
                . "TRIM(REPLACE(REPLACE(REPLACE(content, '\n', ''), '\r', ' '), '\t', ' '))"
                . ", off_start+1, off_end-off_start+1)))) as original, TRIM(TRAILING '.' "
                . "FROM TRIM(TRAILING ',' from TRIM(TRAILING ' ' FROM value))) as variant"))->orhaving('variant','like',$value)->orhaving('original','like',$value)->get();  
        Log::debug($content_recipe);
        $content_title = DB::table(DB::raw("({$sub_title->toSql()}) as data"))
        ->mergeBindings($sub_title->getQuery()) // you need to get underlying Query Builder
        ->leftJoin(DB::raw("recipes AS rcps"), 'rcps.id', '=', 'data.translatable_id')
        ->where("rcps.deleted_at", 'is not', null)
        ->select(DB::raw("user_name, TRIM(TRAILING '.' FROM TRIM(TRAILING ',' FROM TRIM(TRAILING ' ' FROM substring(title, off_start+1, off_end-off_start+1)))) as original, TRIM(TRAILING '.' "
                . "FROM TRIM(TRAILING ',' from TRIM(TRAILING ' ' FROM value))) as variant"))->orhaving('variant','like',$value)->orhaving('original','like',$value)->get(); 
        $content_ingredient = DB::table(DB::raw("({$sub_ingredient->toSql()}) as data"))
        ->mergeBindings($sub_ingredient->getQuery()) // you need to get underlying Query Builder
        ->leftJoin(DB::raw("ingredients AS ingdts"), 'ingdts.id', '=', 'data.translatable_id')
        ->select(DB::raw("user_name, TRIM(TRAILING '.' FROM TRIM(TRAILING ',' FROM TRIM(TRAILING ' ' FROM substring(name, off_start+1, off_end-off_start+1)))) as original, TRIM(TRAILING '.' "
                . "FROM TRIM(TRAILING ',' from TRIM(TRAILING ' ' FROM value))) as variant"))->orhaving('variant','like',$value)->orhaving('original','like',$value)->get();  
        
        
//        $variants_value_recipe=DB::table(DB::raw("({$content_recipe->toSql()}) as data"))
////        ->mergeBindings($content_recipe->getQuery())
//        ->where('original','like',$value)->get();        
//                
//        $variants_value_title=DB::table(DB::raw("({$content_title->toSql()}) as data"))
////        ->mergeBindings($content_title->getQuery())
//        ->where('original','like',$value)->get();        
//                
//        $variants_value_ingredient=DB::table(DB::raw("({$content_ingredient->toSql()}) as data"))
//        ->mergeBindings($content_ingredient->getQuery())
//        ->where('original','like',$value)->get();        
        
        Log::debug("manual variants");
        $manual_variants = AlternativeWord::select(DB::raw('alternative as variant, original, users.name as user_name'))
                ->join('users','users.id', '=', 'user_id')
                ->orhaving('original', 'like', $value)
                ->orhaving('alternative', 'like', $value)->get();

        Log::debug($manual_variants);
        
        $all_variants = $content_recipe->merge($content_title)->merge($content_ingredient)->merge($manual_variants);
        
//        $data::select(DB::raw("TRIM(TRAILING '.' FROM TRIM(TRAILING ',' FROM TRIM(TRAILING ' ' FROM substring(content, off_start+1, off_end-off_start+1)))) as original, TRIM(TRAILING '.' "
//                . "FROM TRIM(TRAILING ',' from TRIM(TRAILING ' ' FROM value))) as variant,"
//                . " \"content\" as content_type"));
//        Log::debug($this->word->select(DB::raw("
//                TRIM(TRAILING '.' FROM TRIM(TRAILING ',' FROM TRIM(TRAILING ' ' FROM substring(content, off_start+1, off_end-off_start+1)))) as original, TRIM(TRAILING '.' FROM TRIM(TRAILING ',' from TRIM(TRAILING ' ' FROM value))) as variant, \"content\" as content_type
//        from (
//		SELECT alt_t.value as value,alt_t.translatable_id, alt_t.offset_start as off_start, alt_t.offset_end as off_end
//		FROM recettes.alternative_texts alt_t  
//	) as augmented_table 
//	LEFT JOIN recipes AS rcps ON (rcps.id = augmented_table.translatable_id)"))->get());
        
//        where translatable_type like \"App\Recipe\" and translatable_attribute like \"content\"
        Log::debug($all_variants);
        return($all_variants);
    }
    
}
