<?php

namespace App\Repositories;

use App\Models\Game;
use App\Models\Sentence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameRepository extends ResourceRepository {

    public function __construct(Game $game) {
        $this->game = $game;
    }

    private function save(Game $game, Array $inputs) {
        $game->user_id = $inputs['user_id'];
        $game->sentence_index = $inputs['sentence_index'];
        $game->save();
    }

    public function store(Array $inputs) {
        debug("store");
        if (Auth::check()) {
            debug("auth checked");

            $user_id = Auth::user()->id;
            debug($user_id);
            $game = new $this->game;
            if ($game->get_single_table_type()=='training') {
                debug("game is training");
                $sentences = $this->get_sentences($user_id)->take(4);
                $this->save($game, $inputs);
                $game->sentences()->attach($sentences);
                return $game;
            } else {
                if ($user_id == 1202) {
                    $sentences = $this->get_sentences_from_orthal();
                } else {
                    $sentences = $this->get_sentences($user_id);
                }
                if ($sentences->count() == 0) {
                    $this->save($game, $inputs);
                    $game->sentences()->attach($sentences);
                    /* game is not null !! */
                    return $game;
                } else {
                    $count = $sentences->count();
                    debug($count);
                    if ($count < 3) {
                        if ($user_id == 1202) {
                            $sentences = $this->get_sentences_from_orthal()->take($count);
                        } else {
                            $sentences = $this->get_sentences($user_id)->take($count);
                        }
                    } else {
                        if ($user_id == 1202) {
                            $sentences = $this->get_sentences_from_orthal()->random(3);
                        } else {
                            $sentences = $this->get_sentences($user_id)->random(3);
                        }
                    }
                    /* get a random sentence from reference (=training?) */
                    $ref_sentence = $this->get_evaluation_sentences()->random(1);

                    $this->save($game, $inputs);
                    $game->sentences()->attach($sentences);
                    $game->sentences()->attach($ref_sentence); 

                    }
                    return $game;
            }
        }
    }

    public function update($id, Array $inputs) {
        $this->save($this->getById($id), $inputs);
    }

    public function destroy($id) {
        $this->getById($id)->delete();
    }

    public function getById($id) {
        return $this->game->findOrFail($id);
    }

    public function getWithUserId($user_id) {
        return $this->game->where('user_id', $user_id)->where('is_finished', 0);
    }

    protected function get_sentences($user_id) {
        /* forces user to annotate on sentences he has'nt annotated yet */
        $id_annotated_sentences = Sentence::select(DB::raw('sentences.id'))
                    ->join('words', 'sentences.id', '=', 'words.sentence_id')
                    ->join('annotations', 'annotations.word_id', '=', 'words.id')
                    ->whereRaw("annotations.confidence_score<10", Array($user_id))
                ->get();
        return Sentence::join('corpora', 'corpora.id', '=', 'sentences.corpus_id')
                        ->select('sentences.*')
                        ->where('corpora.is_training', 0)
                        ->where('corpora.is_active', 1)
                        ->whereNotIn('sentences.id', $id_annotated_sentences)
                        ->get();
        
        /* forces user to annotate on sentences he hasn't annotated yet */
//        $id_annotated_sentences = Sentence::select(DB::raw('sentences.id, count(distinct(users.id)) as count_user '))
//                    ->join('words', 'sentences.id', '=', 'words.sentence_id')
//                    ->join('annotations', 'annotations.word_id', '=', 'words.id')
//                    ->join('users', 'users.id', '=', 'annotations.user_id')
//                    ->join('corpora', 'corpora.id', '=', 'sentences.corpus_id')
//                    ->where('corpora.is_training', 0)   
//                    ->where('corpora.is_active', 1)
//                    ->whereRaw("annotations.confidence_score<10")
//                    ->groupBy('sentences.id')
//                    ->having('count_user','>','2')
//                    ->get();
//        
//        return Sentence::select('sentences.*')->whereNotIn('sentences.id', $id_annotated_sentences)
//                        ->get();
    }

    protected function get_sentences_from_orthal($user_id) {
        $name = "orthal";
        debug(Sentence::join('corpora', 'corpora.id', '=', 'sentences.corpus_id')->where('corpora.id', 322)
                        ->select('sentences.*')
                        ->get());

        return Sentence::join('corpora', 'corpora.id', '=', 'sentences.corpus_id')->where('corpora.id', 322)
                        ->select('sentences.*')
                        ->get();
    }

    protected function get_reference_sentences() {
        debug("getting reference sentences");
        return Sentence::join('corpora', 'corpora.id', '=', 'sentences.corpus_id')
                        ->select('sentences.*')
                        ->where('corpora.is_training', 1)
                        ->where('corpora.id', '=', '62')
                        ->get();
    }

        protected function get_evaluation_sentences() {
        return Sentence::join('corpora', 'corpora.id', '=', 'sentences.corpus_id')
                        ->select('sentences.*')
                        ->where('corpora.is_training', 1)
                        ->whereRaw('corpora.id=42 or corpora.id=52 or corpora.id=72')
                        ->get();
    }
}
