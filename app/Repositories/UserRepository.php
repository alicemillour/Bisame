<?php

namespace App\Repositories;

use App\Models\User;
use DB;

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
    public function get_user_count() {
        return User::select(DB::raw('count(*) as count'))->first();
    }

    public function destroy($id) {
        $this->getById($id)->delete();
    }

}
