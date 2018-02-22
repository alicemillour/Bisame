<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\AnnotationRepository;
use App\Jobs\ChangeLocale;
use App\Recipe;
use Auth, DB;

class TestWelcomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AnnotationRepository $annotationRepository) {
        $this->middleware('admin',['only'=>'language']);
    }

    public function welcome() {
        return view('test-welcome', [
            'recipes' => Recipe::latest()->with('author')->withCount('likes')->orderBy(DB::Raw('annotated+validated'), 'desc')->limit(3)->get(),
            'recipes_to_annotate' => Recipe::toAnnotate()->with('author')->withCount('likes')->latest()->paginate(3),
            'annotated_recipes' => Recipe::toValidate()->with('author')->withCount('likes')->latest()->paginate(3),
            'validated_recipes' => Recipe::where('validated','>',0)->with('author')->withCount('likes')->latest()->paginate(3),            
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
