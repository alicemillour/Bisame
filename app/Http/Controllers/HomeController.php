<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\AnnotationRepository;
use App\Repositories\UserRepository;
use Auth;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $annotationRepository;
    protected $userRepository;

    public function __construct(AnnotationRepository $annotationRepository, UserRepository $userRepository) {
        $this->annotationRepository = $annotationRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        if (!(Auth::guest())) {
            $current_user = Auth::user();
            $game_available = ($current_user->is_in_training == false);
            $non_admin_annotations = $this->annotationRepository->get_total_non_admin_annotations()['annotation_count'];
            $nb_total_users = $this->userRepository->get_users_count()['count'];

            return view('home', compact('game_available', 'current_user','non_admin_annotations','nb_total_users'));
        } else {
            return view('home');
        }
    }

}
