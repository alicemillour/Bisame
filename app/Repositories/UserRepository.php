<?php

namespace App\Repositories;

use App\User;
use DB;
use App\Recipe;
use App\AlternativeText;
use App\AlternativeWord;
use Illuminate\Support\Facades\Log;

class UserRepository extends ResourceRepository {

    //protected $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    private function save(User $user, Array $inputs) {
        $user->name = $inputs['name'];
        $user->email = $inputs['email'];
        $user->admin = isset($inputs['admin']);

        $user->save();
    }

    public function getPaginate($n) {
        return $this->user->paginate($n);
    }

    public function store(Array $inputs) {
        $user = new $this->user;
        $user->password = bcrypt($inputs['password']);
        $this->save($user, $inputs);

        return $user;
    }

    public function getById($id) {
        return $this->user->findOrFail($id);
    }

    public function update($id, Array $inputs) {
        $this->save($this->getById($id), $inputs);
    }

    public function update_confidence_score($user_id, $new_confidence_score) {
        debug("updating confidence score");
        User::where('id');
        User::where('id', $user_id)
                ->update(['score' => $new_confidence_score]);
    }

    public function get_best_users_by_real_score() {
        return User::join("annotations", function($join) {
                            $join->on("annotations.user_id", "=", "users.id");
                        })
                        ->select(DB::raw('count(*)*score as real_score, users.*'))
                        ->groupBy('users.id')
                        ->orderBy('real_score', 'asc')
                        ->where('is_admin', '=', '0')->take(5)->get();
    }

    public function get_around_users_by_real_score($user) {
        $userRank = $this->get_rank_by_real_score($user);
        if ($userRank != null) {
            return User::join("annotations", function($join) {
                                $join->on("annotations.user_id", "=", "users.id");
                            })
                            ->select(DB::raw('count(*)*score as real_score, users.*'))
                            ->groupBy('users.id')
                            ->orderBy('real_score', 'desc')
                            ->where('score', '>', '0')
                            ->skip($userRank - 3)->take(5)->get();
        } else {
            return null;
        }
    }

    public function get_recipe_number_by_user($user_id) {
        return Recipe::select(DB::raw('count(*) as count'))
                        ->where('user_id', '=', $user_id)
                        ->first();
    }
    
    public function get_variant_number_by_user($user_id) {
        return AlternativeText::select(DB::raw('count(*) as count'))
                        ->where('user_id', '=', $user_id)
                        ->first();
    }
    
    public function get_word_variant_number_by_user($user_id) {
        return AlternativeWord::select(DB::raw('count(*) as count'))
                        ->where('user_id', '=', $user_id)
                        ->first();
    }

    public function get_best_users_by_real_score_month() {
        return User::join("annotations", function($join) {
                            $join->on("annotations.user_id", "=", "users.id");
                        })->whereRaw('annotations.created_at > DATE_SUB(CURDATE(), INTERVAL 1 MONTH)')
                        ->select(DB::raw('count(*)*score as real_score, users.*'))
                        ->groupBy('users.id')
                        ->orderBy('real_score', 'desc')
                        ->where('is_admin', '=', '0')->take(5)->get();
    }

    public function get_top_5_recipe_writers() {
        Log::debug(User::join("recipes", function($join) {
                            $join->on("recipes.user_id", "=", "users.id")
                        ->where('recipes.deleted_at','=','NULL');
                        })
                        ->select(DB::raw('count(*) as recipe_count, users.id'))
                        ->groupBy('users.id')
                        ->orderBy('recipe_count', 'desc')
                        ->where('is_admin', '=', '0')->take(10)->get());
                        return false;
        
        return User::join("recipes", function($join) {
                            $join->on("recipes.user_id", "=", "users.id")
                        ->where('recipes.deleted_at','=','NULL');
                        })
                        ->select(DB::raw('count(*) as recipe_count, users.id'))
                        ->groupBy('users.id')
                        ->orderBy('recipe_count', 'desc')
                        ->where('is_admin', '=', '0')->take(10)->get();
    }
    
    public function get_best_users_by_recipes_nb() {
        return User::join("recipes", function($join) {
                                $join->on("recipes.user_id", "=", "users.id")->whereNull('recipes.deleted_at');
                            })
                    ->select(DB::raw('count(*) as recipe_count, users.name'))
                    ->groupBy('users.id')
                    ->orderBy('recipe_count', 'desc')
                    ->where('is_admin', '=', '0')->take(10)->get();
    }    
    
    public function get_best_users_by_poems_nb() {
        return User::join("poems", function($join) {
                                $join->on("poems.user_id", "=", "users.id")->whereNull('poems.deleted_at');
                            })
                    ->select(DB::raw('count(*) as poem_count, users.name'))
                    ->groupBy('users.id')
                    ->orderBy('poem_count', 'desc')
                    ->where('is_admin', '=', '0')->take(10)->get();
    }   
    
    public function get_best_users_by_freetexts_nb() {
        return User::join("freetexts", function($join) {
                                $join->on("freetexts.user_id", "=", "users.id")->whereNull('freetexts.deleted_at');
                            })
                    ->select(DB::raw('count(*) as freetext_count, users.name'))
                    ->groupBy('users.id')
                    ->orderBy('freetext_count', 'desc')
                    ->where('is_admin', '=', '0')->take(10)->get();
    }   
    
    public function get_best_users_by_proverbs_nb() {
        return User::join("proverbs", function($join) {
                                $join->on("proverbs.user_id", "=", "users.id")->whereNull('proverbs.deleted_at');
                            })
                    ->select(DB::raw('count(*) as proverb_count, users.name'))
                    ->groupBy('users.id')
                    ->orderBy('proverb_count', 'desc')
                    ->where('is_admin', '=', '0')->take(10)->get();
    }

    public function get_best_users_by_quantity() {
        return User::join("annotations", function($join) {
                            $join->on("annotations.user_id", "=", "users.id");
                        })
                        ->select(DB::raw('count(*) as quantity, users.*'))
                        ->groupBy('users.id')
                        ->orderBy('quantity', 'desc')
                        ->where('is_admin', '=', '0')
                        ->take(10)->get();
    }

    public function get_best_users_by_alternative() {
        return User::join("alternative_texts", function($join) {
                            $join->on("alternative_texts.user_id", "=", "users.id");
                        })
                        ->select(DB::raw('count(*) as quantity, users.*'))
                        ->groupBy('users.id')
                        ->orderBy('quantity', 'desc')
                        ->where('is_admin', '=', '0')
                        ->take(10)->get();
    }

    public function get_level_by_id($user_id) {
        return User::select('level')->where('id', $user_id)->first()->level;
    }

    public function get_score_by_id($user_id) {
        return User::select('score')->where('id', $user_id)->first()->score;
    }

    public function get_users_count() {
        return User::select(DB::raw('count(*) as count'))->first();
    }
    public function get_active_users_count() {
        return AlternativeText::select(DB::raw('count(distinct(alternative_texts.user_id)) as count'))
                ->leftjoin("alternative_texts", function($join) {
                            $join->on("alternative_texts.user_id", "=", "users.id");
                        })
                
                ->leftjoin("recipes", function($join) {
                            $join->on("recipes.user_id", "=", "users.id");
                        })
                
                ->leftjoin("annotations", function($join) {
                            $join->on("annotations.user_id", "=", "users.id");
                        })->first();
    }

    public function get_not_training_count() {
        debug("get not training users");
        return User::select(DB::raw('count(*) as count'))->where('is_in_training', '=', '0')->first();
    }

    public function get_participant_count() {
        return User::select(DB::raw('count(*) as count'))->where('score', '!=', '0')->first();
    }

    public function get_rank_by_real_score($user) {
        $user_real_score = User::join("annotations", function($join) {
                    $join->on("annotations.user_id", "=", "users.id");
                })
                ->select(DB::raw('count(*)*score as real_score, users.*'))
                ->orderBy('real_score', 'desc')
                ->groupBy('users.id')
                ->where('users.id', '=', $user->id)
                ->first();
        if ($user_real_score == null) {
            /* le participant n'a pas encore produit d'annotation */
            return null;
        } else {
            $cur_score = $user_real_score->real_score;
            $best_users = User::join("annotations", function($join) {
                        $join->on("annotations.user_id", "=", "users.id");
                    })
                    ->select(DB::raw('count(*)*score as real_score, users.*'))
                    ->orderBy('real_score', 'desc')
                    ->groupBy('users.id')
                    ->get();
            $rank = $best_users->filter(function($item, $key) use ($cur_score) {
                        return $item->real_score >= $cur_score;
                    })->count();
            return $rank;
        }
    }

    public function destroy($id) {
        $this->getById($id)->softDeletes();
    }

}
