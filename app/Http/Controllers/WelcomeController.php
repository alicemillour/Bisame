<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\AnnotationRepository;
use App\Repositories\UserRepository;
use App\Jobs\ChangeLocale;
use App\Recipe;
use App\Traits\Badgeable;
use App\User;
use Auth,
    DB;

class WelcomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $userRepository;

    public function __construct(AnnotationRepository $annotationRepository, UserRepository $userRepository) {
        $this->userRepository = $userRepository;
        $this->middleware('admin', ['only' => 'language']);
    }

    public function welcome() {
        return view('welcome', [
            'top5_nb_recipes' => $this->userRepository->get_best_users_by_recipes_nb(),
            'top5_annotations' => $this->userRepository->get_best_users_by_quantity(),
            'top5_variantes' => $this->userRepository->get_best_users_by_alternative(),
            'recipes' => Recipe::latest()->with('author')->withCount('likes')->orderBy(DB::Raw('annotated+validated'), 'desc')->limit(5)->get(),
            'recipe_of_the_day' => Recipe::latest()->with('author')->withCount('likes')->orderBy(DB::Raw('annotated+validated'), 'desc')->limit(1)->get(),
            'recipes_to_annotate' => Recipe::toAnnotate()->with('author')->withCount('likes')->latest()->paginate(3),
            'annotated_recipes' => Recipe::toValidate()->with('author')->withCount('likes')->latest()->paginate(3),
            'validated_recipes' => Recipe::where('validated', '>', 0)->with('author')->withCount('likes')->latest()->paginate(3),
        ]);
    }

    /**
     * Change language.
     *
     * @param  App\Jobs\ChangeLocale $changeLocale
     * @return Illuminate\Http\Response
     */
    public function language(
    ChangeLocale $changeLocale) {
        $this->dispatch($changeLocale);
        return redirect('');
    }

}
