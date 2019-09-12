<?php

namespace App\Http\Controllers;

use App\Recipe;
use App\Ingredient;
use App\User;
use App\Media;
use App\Anecdote;
use App\Corpus;
use App\Postag;
use App\Word;
use App\AnnotatedRecipe;
use App\ValidatedRecipe;
use App;
use Illuminate\Http\Request;
use App\Traits\Badgeable;
use App\Services\WordSeeder;
use App\Services\AnnotationSeeder;
use DB;
use App\Mail\NewRecipe;
use App\Mail\NewAnecdote;
use App\Notification;
use App\Repositories\AnnotationRepository;
use App\Repositories\GameRepository;
use App\Repositories\PostagRepository;
use App\Repositories\SentenceRepository;
use App\Repositories\WordRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class WordController extends Controller {

    use Badgeable;

    protected $sentenceRepository;
    protected $annotationRepository;
    protected $userRepository;
    protected $wordRepository;
    protected $gameSentenceIndex;
    
    public function __construct(WordRepository $wordRepository, AnnotationRepository $annotationRepository, PostagRepository $postagRepository, SentenceRepository $sentenceRepository, UserRepository $userRepository) {
        $this->wordRepository = $wordRepository;
        $this->annotationRepository = $annotationRepository;
        $this->postagRepository = $postagRepository;
        $this->sentenceRepository = $sentenceRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function index(Word $word, Request $request) {
//        // $recipe = Recipe::findOrFail($id);
//        $corpus_recipe = Corpus::where('name', 'like', $recipe->id . '_%')->first();
//        $postags = Postag::orderBy('order')->get();
//        $tab = 'recipe';
//
//        $message = '';
//        $postag = '';
//        if ($request->has('pos')) {
//            $postag = Postag::find($request->input('pos'));
//            $message = "Vous êtes bien entraîné, les " . $postag->name . " n'ont plus de secret pour vous ! Passons aux choses sérieuses :";
//        }
//
//        if ($recipe->annotated) {
//            $annotated_recipe = AnnotatedRecipe::where('recipe_id', $recipe->id)->first();
//            $annotator_to_validate = $annotated_recipe->annotator;
//        } else {
//            $annotator_to_validate = null;
//        }
//
//        if ($request->has('tab')) {
//            $tab = $request->input('tab');
//            if (!in_array($tab, ['plus', 'pos']))
//                $tab = 'recipe';
//            if (in_array($tab, ['plus', 'pos']) && !auth()->check())
//                return redirect()->route('login')->withErrors("Veuillez vous connecter pour accéder à cette partie du site.");
//        }
        

        $sentences = $this->sentenceRepository->getSentencesFromWordValue($word);
        $word_count = $this->wordRepository->get_word_count_by_value($word->value);
        $word_cats = $this->wordRepository->get_word_cats_by_value($word->value); // on a sentence_id correspondant à chaque cat
        $word_variants = $this->wordRepository->get_word_variants_by_value($word->value);
        $word_variants_unique=array_unique(json_decode(json_encode($word_variants), True), SORT_REGULAR);
        
        $word_recipes=null;
        $word_owners=null;
        
        Log::debug("word controller");   
        Log::debug($sentences);
        Log::debug($word_count);

        foreach ($word_variants_unique as $key=>$variant){
            Log::debug($variant);
        }
        return view('words.show', compact('word', 'sentences', 'word_count', 'word_cats', 'word_variants_unique')); 
    }



}
