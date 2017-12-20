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

        return redirect('recipes')->withSuccess(__('recipes.created'));
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