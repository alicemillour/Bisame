<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\AnnotationRepository;
use App\Jobs\ChangeLocale;
use App\Recipe;
use Auth;

class WelcomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AnnotationRepository $annotationRepository) {
        $this->middleware('admin',['only'=>'language']);
    }

    public function welcome() {
        return view('welcome', [
            'recipes' => Recipe::latest()->limit(3)->get(),
        ]);
    }

    /**
     * Change language.
     *
     * @param  App\Jobs\ChangeLocale $changeLocale
     * @return Illuminate\Http\Response
     */
    public function language(
        ChangeLocale $changeLocale)
    {
        $this->dispatch($changeLocale);
        return redirect('');
    }    

}
