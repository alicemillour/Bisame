<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\AnnotationRepository;
use App\Repositories\UserRepository;
use Auth;

class InfoController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct() {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
            return view('info.info');
        }

}
