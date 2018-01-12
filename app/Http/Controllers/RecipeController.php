<?php

namespace App\Http\Controllers;

use App\Recipe;
use App\Ingredient;
use App\User;
use App\Media;
use App\Anecdote;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRecipe;
use App\Http\Requests\StoreAnecdote;
use App\Traits\Badgeable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class RecipeController extends Controller
{
    use Badgeable;

    public function __construct()
    {
        $this->middleware('auth')->only(['create','store','addAnecdote']);
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

        if($request->input('filepath')){
            Media::create([
                'filename'=>$request->input('filepath'),
                'user_id'=>auth()->user()->id,
                'mediable_id' => $recipe->id,
                'mediable_type' => "App\Recipe",
            ]);
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
        
        
        /* lancer les prétraitements */
        $script_path = storage_path().'/app/scripts/';
        $corpus_path = storage_path().'/app/corpus/';
        
        /* tokénisation */
        /* stage 1 : create a raw file with recipe content */  
        $filename = preg_replace('/\W+/', '_', $request->input('title'));
        Storage::put('/corpus/raw/recipes/'.$filename.".txt", $request->input('content'));
        /* stage 2 : create the tokenized file from raw */
        $this->tokenize($filename, $script_path, $corpus_path);
        
        /* stage 3 : create word_seed from tok */
        $this->tok_to_word_seed($filename, $script_path, $corpus_path);

        
        /* stage 4 : create MElt annotated file from tok */
        /* TODO : modèle de MElt à vérifier */
        $this->tok_to_melt($filename, $script_path, $corpus_path);
        
        /* stage 5 : create preannotation seed from MElt annotated file */
        $this->melt_to_preannotation_seed($filename, $script_path, $corpus_path);
        
        /* stage 6 : germanize gsw corpus */
        $this->germanize($filename, $script_path, $corpus_path);
                 
        /* stage 7 : germanize gsw corpus */
        $this->treetag($filename, $script_path, $corpus_path);

        return redirect('recipes')->withSuccess(__('recipes.created'));
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
    
    public function tok_to_word_seed(String $filename, $script_path, $corpus_path) {
        $tokenized_file_url = storage_path().'/app/corpus/tokenized/recipes/'.$filename.'.txt.tok' ;

        $command = escapeshellcmd($script_path . "tok_to_word_seed.sh " . $script_path . " " . $tokenized_file_url . " " . $corpus_path);
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
    
    public function melt_to_preannotation_seed(String $filename, $script_path, $corpus_path) {
        $tokenized_file_url = storage_path().'/app/corpus/tokenized/recipes/'.$filename.'.txt.tok' ;

        $command = escapeshellcmd($script_path . "melt_to_preannotation.sh " . $script_path . " " . $tokenized_file_url . " " . $corpus_path);
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
    
    public function treetag(String $filename, $script_path, $corpus_path) {
        $tokenized_file_url = storage_path().'/app/corpus/tokenized/recipes/'.$filename.'.txt.tok' ;

        $command = escapeshellcmd($script_path . "treetagger.sh " . $script_path . " " . $tokenized_file_url . " " . $corpus_path);
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
     * Display the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        return view('recipes.show',compact('recipe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        // return view('recipes.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe)
    {
        //
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
