<?php

namespace App\Repositories;

use App\User;
use DB;
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
                        ->orderBy('real_score', 'desc')
                        ->where('is_admin', '=', '0')->take(5)->get();
    }
    
    public function get_around_users_by_real_score($user) {
        $userRank = $this->get_rank_by_real_score($user);
        log::debug($userRank);
        
        return User::join("annotations", function($join) {
                            $join->on("annotations.user_id", "=", "users.id");
                        })
                        ->select(DB::raw('count(*)*score as real_score, users.*'))
                        ->groupBy('users.id')
                        ->orderBy('real_score', 'desc')
                        ->where('is_admin', '=', '0')->skip($userRank-6)->take(5)->get();
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

    public function get_best_users_by_quantity() {
        return User::join("annotations", function($join) {
                            $join->on("annotations.user_id", "=", "users.id");
                        })
                        ->select(DB::raw('count(*) as quantity, users.*'))
                        ->groupBy('users.id')
                        ->orderBy('quantity', 'desc')
                        ->where('is_admin', '=', '0')
                        ->take(5)->get();
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
    public function get_not_training_count() {
        debug("get not training users");
        return User::select(DB::raw('count(*) as count'))->where('is_in_training', '=', '0')->first();
    }
    public function get_participant_count() {
        return User::select(DB::raw('count(*) as count'))->where('score', '!=', '0')->first();
    }

    public function get_rank_by_real_score($user)
    {
        $user_real_score=User::join("annotations", function($join) {
                            $join->on("annotations.user_id", "=", "users.id");
                        })
                        ->select(DB::raw('count(*)*score as real_score, users.*'))
                        ->orderBy('real_score', 'asc')
                        ->groupBy('users.id')                                
                        ->where('is_admin', '=', '0')
                        ->where('users.id', '=', $user->id)
                        ->first();
        if ($user_real_score == null){
            $cur_score = 0;
        } else {
            $cur_score = $user_real_score->real_score;
        }
        log::debug("real score ".$cur_score);                        
                                      
        $best_users=User::join("annotations", function($join) {
                            $join->on("annotations.user_id", "=", "users.id");
                        })
                        ->select(DB::raw('count(*)*score as real_score, users.score as score, users.*'))
                        ->orderBy('real_score', 'asc')
                        ->groupBy('users.id')
                        ->where('is_admin', '=', '0')
                        ->get();       
        $rank = $best_users->filter(function($item,$cur_score) {
            return $item->real_score >= $cur_score;
        })->count();
        
        log::debug("rank : " . $rank);
        return $rank;
    }
    
    public function destroy($id) {
        $this->getById($id)->softDeletes();
    }
}
