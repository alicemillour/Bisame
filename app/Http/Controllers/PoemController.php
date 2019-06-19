<?php

namespace App\Http\Controllers;

use App\Poem;
use App\User;
use App\Media;
use App\Anecdote;
use App\Corpus;
use App\Postag;
use App\AnnotatedPoem;
use App\ValidatedPoem;
use App;
use Illuminate\Http\Request;
use App\Http\Requests\StorePoem;
use App\Http\Requests\StoreAnecdote;
use App\Traits\Badgeable;
use App\Services\WordSeeder;
use App\Services\AnnotationSeeder;
use DB;
use App\Mail\NewPoem;
use App\Mail\NewAnecdote;
use App\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PoemController extends Controller {

    use Badgeable;

    public function __construct() {
        $this->middleware('auth')->only(['create', 'store', 'addAnecdote', 'addMedia', 'favorite', 'alternativeVersions', 'annotations', 'flagAsAnnotated', 'flagAsValidated']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($poems = null, $title = null, $subtitle = null) {
        if (!$poems)
            $poems = Poem::with('author')->withCount('likes')->orderBy(DB::Raw('annotated+validated'), 'desc')->latest()->paginate(20);
        if (!$title)
            $title = __('poems.last-poems');

        return view('poems.index', [
            'poems' => $poems,
            'poems_to_annotate' => Poem::with('author')->withCount('likes')->latest()->toAnnotate()->paginate(3),
            'annotated_poems' => Poem::with('author')->withCount('likes')->toValidate()->latest()->paginate(3),
            'validated_poems' => Poem::where('validated', '>', 0)->with('author')->withCount('likes')->latest()->paginate(3),
            'title' => $title,
            'subtitle' => $subtitle,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user(User $user) {
        $poems = Poem::with('author')->withCount('likes')->where('user_id', $user->id)->latest()->paginate(20);

        $title = __('poems.poems-by', ['name' => $user->name]);

        return $this->index($poems, $title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $poems = Poem::with('author')->withCount('likes')->where('title', 'LIKE', '%' . $request->input('search') . '%')->latest()->paginate(20);

        $title = __('poems.search-result', ['search' => $request->input('search')]);

        return $this->index($poems, $title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function favorite(Request $request) {
        $poems = Poem::with('author')->withCount('likes')->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                            ->from('likes')
                            ->where('likes.user_id', auth()->user()->id)
                            ->where('likes.likeable_type', 'App\Poem')
                            ->whereRaw('likes.likeable_id = poems.id');
                })->paginate(20);

        $title = __('poems.favorite', ['search' => $request->input('search')]);

        return $this->index($poems, $title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function toAnnotate(Request $request) {
        $poems = Poem::with('author')->withCount('likes')->toAnnotate()->paginate(20);
        $title = __('poems.to-annotate');
        $subtitle = __('poems.to-annotate-exp');
        return $this->index($poems, $title, $subtitle);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function toValidate(Request $request) {
        $poems = Poem::with('author')->withCount('likes')->toValidate()->paginate(20);
        $title = __('poems.to-validate');
        $subtitle = __('poems.to-validate-exp');
        return $this->index($poems, $title, $subtitle);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('poems.create')->with('type', "poems");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePoem $request) {
        $poem = Poem::create(array_merge($request->all(), array(
                    'user_id' => auth()->user()->id,
                    'corpus_language_id' => 1,
                    'category_id' => $request->input('category_id')
        )));

        if ($request->input('anecdote')) {
            Anecdote::create([
                'user_id' => auth()->user()->id,
                'recipe_id' => $poem->id,
                'content' => $request->input('anecdote'),
            ]);
        }

        if ($request->input('photos')) {
            foreach ($request->input('photos') as $photo) {
                Media::create([
                    'filename' => $photo,
                    'user_id' => auth()->user()->id,
                    'mediable_id' => $poem->id,
                    'mediable_type' => "App\Poem",
                ]);
            }
        }

       //$this->checkBadge($request, 'poem', auth()->user()->poems()->count());

        //self::sendMailNewPoem($poem);
        
        
        /* Fonctionnalité d'annotation : commenter la ligne ci-dessous pour poursuivre l'exécution i.e. prétraitements et redirection vers l'annotation) */
        // return redirect('/')->withSuccess(__('poems.created'));
        /* Fonctionnalité d'annotation */

        /* lancer les prétraitements */
        $script_path = base_path() . '/scripts/'.App::getLocale().'/';
        $corpus_path = storage_path() . '/app/'.App::getLocale().'/corpus/';


        /* tokénisation */
        /* stage 1 : create a raw file with poem content */
        $filename = preg_replace('/\W+/', '_', $request->input('title'));
        $corpus_name = $poem->id . "_" . $filename;
        Storage::put(App::getLocale().'/corpus/raw/recipes/' . $filename . ".txt", $request->input('content'));
        /* stage 2 : create the tokenized file from raw */
        
        $this->tokenize($filename, $script_path, $corpus_path);
        
        /* stage 3 : create word_seed from tok */
        $this->tok_to_word_seed($filename, $script_path, $corpus_path, $corpus_name);


        /* stage 4 : create MElt annotated file from tok */
        /* TODO : modèle de MElt à vérifier */
        $this->tok_to_melt($filename, $script_path, $corpus_path);

        /* stage 5 : create preannotation seed from annotated file */
        $this->brown_to_preannotation_seed($filename, $script_path, $corpus_path, $corpus_name);

        /* Création corpus */
        Corpus::create([
            'name' => $corpus_name,
        ]);

        /* Seed words */
        Log::debug($corpus_path . "/word_seed/recipes/" . $filename . '.word_seed');
        $seeder = new WordSeeder($corpus_path . "/word_seed/recipes/" . $filename . '.word_seed');
        $seeder->run();

        /* Seed preannotations */
        $seeder = new AnnotationSeeder($corpus_path . "/preannotation/preannotation-1/recipes/" . $filename . '.preannotation_seed');
        $seeder->run();

        return redirect('poems/' . $poem->id . '?tab=pos')->withSuccess(__('poems.created'));
    }

    public function sendMailNewPoem(Poem $poem) {

        $notification = Notification::where('slug', 'all-poems')->first();

        foreach ($notification->users as $user) {
            if ($user->email != '') {
                Mail::to($user)->queue(new NewPoem($poem));
            }
        }
    }

    public function sendMailNewAnecdote(Poem $poem, Anecdote $anecdote) {

        $notification = Notification::where('slug', 'anecdotes')->first();

        $users = $notification->users()->where('user_id', $poem->user_id)->get();

        foreach ($users as $user) {
            if ($user->email != '') {
                Mail::to($user)->queue(new NewAnecdote($poem, $anecdote));
            }
        }
    }

    public function tokenize(String $filename, String $script_path, String $corpus_path) {
        $raw_file_url = storage_path() . '/app/'.App::getLocale().'/corpus/raw/recipes/' . $filename . '.txt';

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

    public function tok_to_word_seed($filename, $script_path, $corpus_path, $corpus_name) {
        $tokenized_file_url = storage_path() . '/app/'.App::getLocale().'/corpus/tokenized/recipes/' . $filename . '.txt.tok';

        $command = escapeshellcmd($script_path . "word_to_seed.sh " . $script_path . " " . $tokenized_file_url . " " . $corpus_path . " " . $corpus_name);
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
        $tokenized_file_url = storage_path() . '/app/'.App::getLocale().'/corpus/tokenized/recipes/' . $filename . '.txt.tok';

        $command = escapeshellcmd($script_path . "preannotate.sh " . $script_path . " " . $tokenized_file_url . " " . $corpus_path);
        Log::debug("commande : " . $command);
        $process = new Process($command);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            Log::debug("process failed !!!");
            throw new ProcessFailedException($process);
        }
    }

    public function brown_to_preannotation_seed(String $filename, $script_path, $corpus_path, $corpus_name) {
        $tokenized_file_url = storage_path() . '/app/'.App::getLocale().'/corpus/tokenized/recipes/' . $filename . '.txt.tok';

        $command = escapeshellcmd($script_path . "preannotation_to_seed.sh " . $script_path . " " . $tokenized_file_url . " " . $corpus_path . " " . $corpus_name);
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
        $tokenized_file_url = storage_path() . '/app/'.App::getLocale().'/tokenized/recipes/' . $filename . '.txt.tok';

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
        $tokenized_file_url = storage_path() . '/app/'.App::getLocale().'/tokenized/recipes/' . $filename . '.txt.tok';

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
    public function addAnecdote(StoreAnecdote $request) {

        $poem = Poem::findOrFail($request->input('poem_id'));

        $anecdote = Anecdote::create([
            'user_id' => auth()->user()->id,
            'recipe_id' => $request->input('poem_id'),
            'content' => $request->input('anecdote'),
        ]);

        $this->checkBadge($request, 'anecdote', auth()->user()->anecdotes()->count());

        self::sendMailNewAnecdote($poem, $anecdote);

        return redirect('poems/' . $request->input('poem_id'))->withSuccess(__('poems.anecdote-created'));
    }

    /**
     * Store a new anecdote.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addMedia(Request $request, Poem $poem) {
        if ($request->input('photos')) {
            foreach ($request->input('photos') as $photo) {
                Media::create([
                    'filename' => $photo,
                    'user_id' => auth()->user()->id,
                    'mediable_id' => $poem->id,
                    'mediable_type' => "App\Poem",
                ]);
            }
        }

        return redirect('poems/' . $request->input('poem_id'))->withSuccess(__('poems.photo-added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Poem  $poem
     * @return \Illuminate\Http\Response
     */
    public function show(Poem $poem, Request $request) {
        // $poem = Poem::findOrFail($id);
        $corpus_poem = Corpus::where('name', 'like', $poem->id . '_%')->first();
        $postags = Postag::orderBy('order')->get();
        $tab = 'poem';

        $message = '';
        $postag = '';
        if ($request->has('pos')) {
            $postag = Postag::find($request->input('pos'));
            $message = "Vous êtes bien entraîné, les " . $postag->name . " n'ont plus de secret pour vous ! Passons aux choses sérieuses :";
        }

        if ($poem->annotated) {
            $annotated_poem = AnnotatedPoem::where('recipe_id', $poem->id)->first();
            $annotator_to_validate = $annotated_poem->annotator;
        } else {
            $annotator_to_validate = null;
        }

        if ($request->has('tab')) {
            $tab = $request->input('tab');
            if (!in_array($tab, ['plus', 'pos']))
                $tab = 'poem';
            if (in_array($tab, ['plus', 'pos']) && !auth()->check())
                return redirect()->route('login')->withErrors("Veuillez vous connecter pour accéder à cette partie du site.");
        }
        return view('poems.show', compact('poem', 'annotator_to_validate', 'corpus_poem', 'postags', 'tab', 'message', 'postag'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addAltVersion(Request $request) {
        $poem = Poem::inRandomOrder()->first();
        $title = __('poems.add-variant');
        $subtitle = __('poems.add-variant-exp');
        $request->session()->flash('title', $title);
        $request->session()->flash('subtitle', $subtitle);
        return redirect('poems/' . $poem->id . '?tab=plus');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Poem  $poem
     * @return \Illuminate\Http\Response
     */
    public function alternativeVersions(Poem $poem, Request $request) {
        $request->merge(['tab' => 'plus']);
        return self::show($poem, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Poem  $poem
     * @return \Illuminate\Http\Response
     */
    public function annotations(Poem $poem, Request $request) {
        $request->merge(['tab' => 'pos']);
        return self::show($poem, $request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Poem  $poem
     * @return \Illuminate\Http\Response
     */
    public function edit(Poem $poem) {
        $this->authorize('update', $poem);

        return view('poems.edit', compact('poem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Poem  $poem
     * @return \Illuminate\Http\Response
     */
    public function update(StorePoem $request, Poem $poem) {
        $this->authorize('update', $poem);

        $poem->update($request->all());

        Media::where('user_id', auth()->user()->id)->where('mediable_id', $poem->id)->where('mediable_type', 'App\Poem')->delete();

        if ($request->input('photos')) {
            foreach ($request->input('photos') as $photo) {
                Media::create([
                    'filename' => $photo,
                    'user_id' => auth()->user()->id,
                    'mediable_id' => $poem->id,
                    'mediable_type' => "App\Poem",
                ]);
            }
        }

        return redirect('poems')->withSuccess(__('poems.updated'));
    }

    /**
     * Flag a poem as annotated
     *
     * @param  \App\Poem  $poem
     * @return \Illuminate\Http\Response
     */
    public function flagAsAnnotated(Poem $poem) {
        $user = auth()->user();
        if (!AnnotatedPoem::where('poem_id', $poem->id)->where('user_id', $user->id)->exists()) {
            AnnotatedPoem::create(['poem_id' => $poem->id, 'user_id' => $user->id]);
            $poem->increment('annotated');
        }
    }

    /**
     * Flag a poem as verified
     *
     * @param  \App\Poem  $poem
     * @return \Illuminate\Http\Response
     */
    public function flagAsValidated(Poem $poem) {
        $user = auth()->user();
        if (!ValidatedPoem::where('poem_id', $poem->id)->where('user_id', $user->id)->exists()) {
            ValidatedPoem::create(['poem_id' => $poem->id, 'user_id' => $user->id]);
            $poem->increment('validated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Poem  $poem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poem $poem) {
        //
    }

}
