<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\AnnotationRepository;

use Auth;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
      protected $annotationRepository;  

    public function __construct(AnnotationRepository $annotationRepository)
    {
        $this->annotationRepository = $annotationRepository;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_user = Auth::user();
        $game_available = ($current_user->is_in_training == false);
        $nb_total_annotations = $this->annotationRepository->get_total_non_admin_annotations()['annotation_count'];
        return view('welcome', compact('game_available','current_user', 'nb_total_annotations'));
    }
}
