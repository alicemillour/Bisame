<?php

namespace App\Http\Controllers;

use App\Recipe;
use App\Ingredient;
use App\User;
use App\Media;
use App\Anecdote;
use App\Corpus;
use App\Postag;
use App;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRecipe;
use App\Http\Requests\StoreAnecdote;
use App\Traits\Badgeable;
use App\Services\WordSeeder;
use App\Services\AnnotationSeeder;
use DB;
use App\Mail\NewRecipe;
use App\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class RecipeController extends Controller
{
    use Badgeable;

    public function __construct()
    {
        $this->middleware('auth')->only(['create','store','addAnecdote','addMedia','favorite','alternativeVersions','annotations']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('recipes.index', [
            'recipes' => Recipe::with('author')->withCount('likes')->latest()->paginate(20),
            'recipes_to_annotate' => Recipe::where('annotated','=',0)->with('author')->withCount('likes')->latest()->paginate(3),
            'annotated_recipes' => Recipe::where('annotated','>',0)->with('author')->withCount('likes')->latest()->paginate(3),
            'validated_recipes' => Recipe::where('validated','>',0)->with('author')->withCount('likes')->latest()->paginate(3),
            'title' => __('recipes.last-recipes')
        ]);
    }    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user(User $user)
    {
        return view('recipes.index', [
            'recipes' => Recipe::with('author')->withCount('likes')->where('user_id',$user->id)->latest()->paginate(20),
            'user' => $user,
            'title' => __('recipes.recipes-by', ['name' => $user->name])
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        return view('recipes.index', [
            'recipes' => Recipe::with('author')->withCount('likes')->where('title','LIKE','%'.$request->input('search').'%')->latest()->paginate(20),
            'title' => __('recipes.search-result', ['search' => $request->input('search')])
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function favorite(Request $request)
    {
        return view('recipes.index', [
            'recipes' => Recipe::with('author')->withCount('likes')->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('likes')
                      ->where('likes.user_id', auth()->user()->id)
                      ->where('likes.likeable_type', 'App\Recipe')
                      ->whereRaw('likes.likeable_id = recipes.id');
            })->paginate(20),
            'title' => __('recipes.favorite', ['search' => $request->input('search')])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recipes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecipe $request)
    {
        $recipe = Recipe::create(array_merge($request->all(),array(
                'user_id'=>auth()->user()->id,
                'corpus_language_id' => 1
            )));

        if($request->input('anecdote')){
            Anecdote::create([
                'user_id'=>auth()->user()->id,
                'recipe_id' => $recipe->id,
                'content' => $request->input('anecdote'),
            ]);
        }

        if($request->input('photos')){
            foreach($request->input('photos') as $photo){
                Media::create([
                    'filename'  =>$photo,
                    'user_id'   =>auth()->user()->id,
                    'mediable_id' => $recipe->id,
                    'mediable_type' => "App\Recipe",
                ]);
            }
        }

        if(is_array($request->input('ingredient'))){
            $ingredients = $request->input('ingredient');
            foreach($ingredients as $ingredient){
                if($ingredient['name']) {
                    Ingredient::create([
                        'recipe_id' => $recipe->id,
                        // 'quantity' => $ingredient['quantity'],
                        'name' => $ingredient['name'],
                    ]);
                }
            }
        }

        $this->checkBadge($request, 'recipe', auth()->user()->recipes()->count());

        self::sendMailNewRecipe($recipe);
        
        /* lancer les prétraitements */
        $script_path = base_path().'/scripts/';
        $corpus_path = storage_path().'/app/corpus/';

        
        /* tokénisation */
        /* stage 1 : create a raw file with recipe content */  
        $filename = preg_replace('/\W+/', '_', $request->input('title'));
        $corpus_name = $recipe->id."_".$filename;
        Storage::put('/corpus/raw/recipes/'.$filename.".txt", $request->input('content'));
        /* stage 2 : create the tokenized file from raw */
        $this->tokenize($filename, $script_path, $corpus_path);
        
        /* stage 3 : create word_seed from tok */
        $this->tok_to_word_seed($filename, $script_path, $corpus_path, $corpus_name);

        
        /* stage 4 : create MElt annotated file from tok */
        /* TODO : modèle de MElt à vérifier */
        $this->tok_to_melt($filename, $script_path, $corpus_path);
        
        /* stage 5 : create preannotation seed from MElt annotated file */
        $this->melt_to_preannotation_seed($filename, $script_path, $corpus_path, $corpus_name);
        
        /* stage 6 : germanize gsw corpus */
        $this->germanize($filename, $script_path, $corpus_path);
                 
        /* stage 7 : germanize gsw corpus */
        $this->treetag($filename, $script_path, $corpus_path, $corpus_name);

        /* Création corpus */
        Corpus::create([
            'name' => $corpus_name,
        ]);
        
        /* Seed words */
        Log::debug($corpus_path."/word_seed/recipes/".$filename.'.word_seed');
        $seeder = new WordSeeder($corpus_path."/word_seed/recipes/".$filename.'.word_seed');
        $seeder->run();
        
        /* Seed preannotations */
        Log::debug($corpus_path."/preannotation/MElt/recipes/".$filename.'.melt_pre-annotation_seed');
        Log::debug($corpus_path."/preannotation/Treetagger/recipes/".$filename.'.treetag_pre-annotation_seed');
        $seeder = new AnnotationSeeder($corpus_path."/preannotation/MElt/recipes/".$filename.'.melt_pre-annotation_seed');
        $seeder->run();
//        Préannotation avec treetagger à corriger 
//        $seeder = new AnnotationSeeder($corpus_path."/preannotation/TreeTagger/recipes/".$filename.'.treetag_pre-annotation_seed');
//        $seeder->run();
        return redirect('recipes/'.$recipe->id.'?tab=pos')->withSuccess(__('recipes.created'));

    }

    public function sendMailNewRecipe(Recipe $recipe){
        
        $notification = Notification::where('slug','all-recipes')->first();

        foreach($notification->users as $user){
            Mail::to($user)->queue(new NewRecipe($recipe));
        }
    }

    public function tokenize(String $filename, String $script_path, String $corpus_path){
        $raw_file_url = storage_path().'/app/corpus/raw/recipes/'.$filename.'.txt' ;
        
        $command = escapeshellcmd($script_path . "tokenize.sh " . $script_path . " " . $raw_file_url . " " . $corpus_path);
        Log::debug("commande : " . $command);
        $process = new Process($command);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            Log::debug("process failed !!!");            
            throw new ProcessFailedException($process);
        }
    }
    
    public function tok_to_word_seed( $filename, $script_path, $corpus_path, $corpus_name) {
        $tokenized_file_url = storage_path().'/app/corpus/tokenized/recipes/'.$filename.'.txt.tok' ;

        $command = escapeshellcmd($script_path . "tok_to_word_seed.sh " . $script_path . " " . $tokenized_file_url . " " . $corpus_path  . " " . $corpus_name);
        Log::debug("commande : " . $command);
        $process = new Process($command);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            Log::debug("process failed !!!");            
            throw new ProcessFailedException($process);
        }

    }
    
    public function tok_to_melt(String $filename, $script_path, $corpus_path) {
        $tokenized_file_url = storage_path().'/app/corpus/tokenized/recipes/'.$filename.'.txt.tok' ;

        $command = escapeshellcmd($script_path . "tok_to_melt.sh " . $script_path . " " . $tokenized_file_url . " " . $corpus_path);
        Log::debug("commande : " . $command);
        $process = new Process($command);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            Log::debug("process failed !!!");            
            throw new ProcessFailedException($process);
        }
    }
    
    public function melt_to_preannotation_seed(String $filename, $script_path, $corpus_path, $corpus_name) {
        $tokenized_file_url = storage_path().'/app/corpus/tokenized/recipes/'.$filename.'.txt.tok' ;

        $command = escapeshellcmd($script_path . "melt_to_preannotation.sh " . $script_path . " " . $tokenized_file_url . " " . $corpus_path. " " . $corpus_name);
        Log::debug("commande : " . $command);
        $process = new Process($command);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            Log::debug("process failed !!!");            
            throw new ProcessFailedException($process);
        }
    }
    
    public function germanize(String $filename, $script_path, $corpus_path) {
        $tokenized_file_url = storage_path().'/app/corpus/tokenized/recipes/'.$filename.'.txt.tok' ;

        $command = escapeshellcmd($script_path . "germanize.sh " . $script_path . " " . $tokenized_file_url . " " . $corpus_path);
        Log::debug("commande : " . $command);
        $process = new Process($command);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            Log::debug("process failed !!!");            
            throw new ProcessFailedException($process);
        }
    }
    
    public function treetag(String $filename, $script_path, $corpus_path, $corpus_name) {
        $tokenized_file_url = storage_path().'/app/corpus/tokenized/recipes/'.$filename.'.txt.tok' ;

        $command = escapeshellcmd($script_path . "treetagger.sh " . $script_path . " " . $tokenized_file_url . " " . $corpus_path . " " . $corpus_name);
        Log::debug("commande : " . $command);
        $process = new Process($command);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            Log::debug("process failed !!!");            
            throw new ProcessFailedException($process);
        }
    }
    
    /**
     * Store a new anecdote.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addAnecdote(StoreAnecdote $request)
    {
        Anecdote::create([
            'user_id'=>auth()->user()->id,
            'recipe_id' => $request->input('recipe_id'),
            'content' => $request->input('anecdote'),
        ]);

        $this->checkBadge($request, 'anecdote', auth()->user()->anecdotes()->count());

        return redirect('recipes/'.$request->input('recipe_id'))->withSuccess(__('recipes.anecdote-created'));
    }

    /**
     * Store a new anecdote.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addMedia(Request $request, Recipe $recipe)
    {
        if($request->input('photos')){
            foreach($request->input('photos') as $photo){
                Media::create([
                    'filename'  =>$photo,
                    'user_id'   =>auth()->user()->id,
                    'mediable_id' => $recipe->id,
                    'mediable_type' => "App\Recipe",
                ]);
            }
        }

        return redirect('recipes/'.$request->input('recipe_id'))->withSuccess(__('recipes.photo-added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe, Request $request)
    {
        $corpus_recipe = Corpus::where('name','like',$recipe->id.'_%')->first();
        $postags = Postag::orderBy('order')->get();
        $tab = 'recipe';
        
        // $words = $corpus_recipe->sentences->words;

        if(auth()->check()){
            $annotations_user = [];
        } else {
            $annotations_user = [];
        }

        $message = '';
        if($request->has('pos')){
            $postag = Postag::find($request->input('pos'));
            $message = "Vous êtes bien entraîné, les ".$postag->name." n'ont plus de secret pour vous ! Passons aux choses sérieuses :";
        }

        if($request->has('tab')){
            $tab = $request->input('tab');
            if(!in_array($tab,['plus','pos']))
                $tab = 'recipe';
            if(in_array($tab,['plus','pos']) && !auth()->check())
                return redirect()->route('login')->withErrors("Veuillez vous connecter pour accéder à cette partie du site.");
        }
        return view('recipes.show',compact('recipe','corpus_recipe','postags','tab','message'));
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function alternativeVersions(Recipe $recipe, Request $request)
    {
        $request->merge(['tab' => 'plus']);
        return self::show($recipe, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function annotations(Recipe $recipe, Request $request)
    {
        $request->merge(['tab' => 'pos']);
        return self::show($recipe, $request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        $this->authorize('update', $recipe);

        return view('recipes.edit',compact('recipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRecipe $request, Recipe $recipe)
    {
        $this->authorize('update', $recipe);

        $recipe->update($request->all());

        Media::where('user_id', auth()->user()->id)->where('mediable_id', $recipe->id)->where('mediable_type', 'App\Recipe')->delete();
        Ingredient::where('recipe_id', $recipe->id)->delete();

        if($request->input('photos')){
            foreach($request->input('photos') as $photo){
                Media::create([
                    'filename'  =>$photo,
                    'user_id'   =>auth()->user()->id,
                    'mediable_id' => $recipe->id,
                    'mediable_type' => "App\Recipe",
                ]);
            }
        }

        if(is_array($request->input('ingredient'))){
            $ingredients = $request->input('ingredient');
            foreach($ingredients as $ingredient){
                if($ingredient['name']) {
                    Ingredient::create([
                        'recipe_id' => $recipe->id,
                        'name' => $ingredient['name'],
                    ]);
                }
            }
        }

        return redirect('recipes')->withSuccess(__('recipes.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        //
    }
}
