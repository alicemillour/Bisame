<?php

namespace App\Http\Controllers;

use App\Proverb;
use App\User;
use App\Media;
use App\Anecdote;
use App\Corpus;
use App\Postag;
use App\AnnotatedProverb;
use App\ValidatedProverb;
use App;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProverb;
use App\Http\Requests\StoreAnecdote;
use App\Traits\Badgeable;
use App\Services\WordSeeder;
use App\Services\AnnotationSeeder;
use DB;
use App\Mail\NewProverb;
use App\Mail\NewAnecdote;
use App\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ProverbController extends Controller {

    use Badgeable;

    public function __construct() {
        $this->middleware('auth')->only(['create', 'store', 'addAnecdote', 'addMedia', 'favorite', 'alternativeVersions', 'annotations', 'flagAsAnnotated', 'flagAsValidated']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($proverbs = null, $title = null, $subtitle = null) {
        if (!$proverbs)
            $proverbs = Proverb::with('author')->withCount('likes')->orderBy(DB::Raw('annotated+validated'), 'desc')->latest()->paginate(20);
        if (!$title)
            $title = __('proverbs.last-proverbs');

        return view('proverbs.index', [
            'proverbs' => $proverbs,
            'proverbs_to_annotate' => Proverb::with('author')->withCount('likes')->latest()->toAnnotate()->paginate(3),
            'annotated_proverbs' => Proverb::with('author')->withCount('likes')->toValidate()->latest()->paginate(3),
            'validated_proverbs' => Proverb::where('validated', '>', 0)->with('author')->withCount('likes')->latest()->paginate(3),
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
        $proverbs = Proverb::with('author')->withCount('likes')->where('user_id', $user->id)->latest()->paginate(20);

        $title = __('proverbs.proverbs-by', ['name' => $user->name]);

        return $this->index($proverbs, $title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $proverbs = Proverb::with('author')->withCount('likes')->where('title', 'LIKE', '%' . $request->input('search') . '%')->latest()->paginate(20);

        $title = __('proverbs.search-result', ['search' => $request->input('search')]);

        return $this->index($proverbs, $title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function favorite(Request $request) {
        $proverbs = Proverb::with('author')->withCount('likes')->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                            ->from('likes')
                            ->where('likes.user_id', auth()->user()->id)
                            ->where('likes.likeable_type', 'App\Proverb')
                            ->whereRaw('likes.likeable_id = proverbs.id');
                })->paginate(20);

        $title = __('proverbs.favorite', ['search' => $request->input('search')]);

        return $this->index($proverbs, $title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function toAnnotate(Request $request) {
        $proverbs = Proverb::with('author')->withCount('likes')->toAnnotate()->paginate(20);
        $title = __('proverbs.to-annotate');
        $subtitle = __('proverbs.to-annotate-exp');
        return $this->index($proverbs, $title, $subtitle);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function toValidate(Request $request) {
        $proverbs = Proverb::with('author')->withCount('likes')->toValidate()->paginate(20);
        $title = __('proverbs.to-validate');
        $subtitle = __('proverbs.to-validate-exp');
        return $this->index($proverbs, $title, $subtitle);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('proverbs.create')->with('type', "proverbs");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProverb $request) {
        $proverb = Proverb::create(array_merge($request->all(), array(
                    'user_id' => auth()->user()->id,
                    'corpus_language_id' => 1,
                    'category_id' => $request->input('category_id')
        )));

        if ($request->input('anecdote')) {
            Anecdote::create([
                'user_id' => auth()->user()->id,
                'recipe_id' => $proverb->id,
                'content' => $request->input('anecdote'),
            ]);
        }

        if ($request->input('photos')) {
            foreach ($request->input('photos') as $photo) {
                Media::create([
                    'filename' => $photo,
                    'user_id' => auth()->user()->id,
                    'mediable_id' => $proverb->id,
                    'mediable_type' => "App\Proverb",
                ]);
            }
        }

       $this->checkBadge($request, 'proverb', auth()->user()->proverbs()->count());

        //self::sendMailNewProverb($proverb);
        
        
        /* Fonctionnalité d'annotation : commenter la ligne ci-dessous pour poursuivre l'exécution i.e. prétraitements et redirection vers l'annotation) */
        // return redirect('/')->withSuccess(__('proverbs.created'));
        /* Fonctionnalité d'annotation */

        /* lancer les prétraitements */
        $script_path = base_path() . '/scripts/'.App::getLocale().'/';
        $corpus_path = storage_path() . '/app/'.App::getLocale().'/corpus/';


        /* tokénisation */
        /* stage 1 : create a raw file with proverb content */
        $filename = preg_replace('/\W+/', '_', $request->input('title'));
        $corpus_name = "proverb_" . $proverb->id . "_" . $filename;
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

        return redirect('proverbs/' . $proverb->id . '?tab=pos')->withSuccess(__('proverbs.created'));
    }

    public function sendMailNewProverb(Proverb $proverb) {

        $notification = Notification::where('slug', 'all-proverbs')->first();

        foreach ($notification->users as $user) {
            if ($user->email != '') {
                Mail::to($user)->queue(new NewProverb($proverb));
            }
        }
    }

    public function sendMailNewAnecdote(Proverb $proverb, Anecdote $anecdote) {

        $notification = Notification::where('slug', 'anecdotes')->first();

        $users = $notification->users()->where('user_id', $proverb->user_id)->get();

        foreach ($users as $user) {
            if ($user->email != '') {
                Mail::to($user)->queue(new NewAnecdote($proverb, $anecdote));
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

        $proverb = Proverb::findOrFail($request->input('proverb_id'));

        $anecdote = Anecdote::create([
            'user_id' => auth()->user()->id,
            'recipe_id' => $request->input('proverb_id'),
            'content' => $request->input('anecdote'),
        ]);

        $this->checkBadge($request, 'anecdote', auth()->user()->anecdotes()->count());

        self::sendMailNewAnecdote($proverb, $anecdote);

        return redirect('proverbs/' . $request->input('proverb_id'))->withSuccess(__('proverbs.anecdote-created'));
    }

    /**
     * Store a new anecdote.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addMedia(Request $request, Proverb $proverb) {
        if ($request->input('photos')) {
            foreach ($request->input('photos') as $photo) {
                Media::create([
                    'filename' => $photo,
                    'user_id' => auth()->user()->id,
                    'mediable_id' => $proverb->id,
                    'mediable_type' => "App\Proverb",
                ]);
            }
        }

        return redirect('proverbs/' . $request->input('proverb_id'))->withSuccess(__('proverbs.photo-added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proverb  $proverb
     * @return \Illuminate\Http\Response
     */
    public function show(Proverb $proverb, Request $request) {
        // $proverb = Proverb::findOrFail($id);
        $corpus_proverb = Corpus::where('name', 'like', 'proverb_' . $proverb->id . '_%')->first();
        $postags = Postag::orderBy('order')->get();
        $tab = 'proverb';

        $message = '';
        $postag = '';
        if ($request->has('pos')) {
            $postag = Postag::find($request->input('pos'));
            $message = "Vous êtes bien entraîné, les " . $postag->name . " n'ont plus de secret pour vous ! Passons aux choses sérieuses :";
        }

        if ($proverb->annotated) {
            $annotated_proverb = AnnotatedProverb::where('recipe_id', $proverb->id)->first();
            $annotator_to_validate = $annotated_proverb->annotator;
        } else {
            $annotator_to_validate = null;
        }

        if ($request->has('tab')) {
            $tab = $request->input('tab');
            if (!in_array($tab, ['plus', 'pos']))
                $tab = 'proverb';
            if (in_array($tab, ['plus', 'pos']) && !auth()->check())
                return redirect()->route('login')->withErrors("Veuillez vous connecter pour accéder à cette partie du site.");
        }
        return view('proverbs.show', compact('proverb', 'annotator_to_validate', 'corpus_proverb', 'postags', 'tab', 'message', 'postag'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addAltVersion(Request $request) {
        $proverb = Proverb::inRandomOrder()->first();
        $title = __('proverbs.add-variant');
        $subtitle = __('proverbs.add-variant-exp');
        $request->session()->flash('title', $title);
        $request->session()->flash('subtitle', $subtitle);
        return redirect('proverbs/' . $proverb->id . '?tab=plus');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proverb  $proverb
     * @return \Illuminate\Http\Response
     */
    public function alternativeVersions(Proverb $proverb, Request $request) {
        $request->merge(['tab' => 'plus']);
        return self::show($proverb, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proverb  $proverb
     * @return \Illuminate\Http\Response
     */
    public function annotations(Proverb $proverb, Request $request) {
        $request->merge(['tab' => 'pos']);
        return self::show($proverb, $request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proverb  $proverb
     * @return \Illuminate\Http\Response
     */
    public function edit(Proverb $proverb) {
        $this->authorize('update', $proverb);

        return view('proverbs.edit', compact('proverb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proverb  $proverb
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProverb $request, Proverb $proverb) {
        $this->authorize('update', $proverb);

        $proverb->update($request->all());

        Media::where('user_id', auth()->user()->id)->where('mediable_id', $proverb->id)->where('mediable_type', 'App\Proverb')->delete();

        if ($request->input('photos')) {
            foreach ($request->input('photos') as $photo) {
                Media::create([
                    'filename' => $photo,
                    'user_id' => auth()->user()->id,
                    'mediable_id' => $proverb->id,
                    'mediable_type' => "App\Proverb",
                ]);
            }
        }

        return redirect('proverbs')->withSuccess(__('proverbs.updated'));
    }

    /**
     * Flag a proverb as annotated
     *
     * @param  \App\Proverb  $proverb
     * @return \Illuminate\Http\Response
     */
    public function flagAsAnnotated(Proverb $proverb) {
        $user = auth()->user();
        if (!AnnotatedProverb::where('proverb_id', $proverb->id)->where('user_id', $user->id)->exists()) {
            AnnotatedProverb::create(['proverb_id' => $proverb->id, 'user_id' => $user->id]);
            $proverb->increment('annotated');
        }
    }

    /**
     * Flag a proverb as verified
     *
     * @param  \App\Proverb  $proverb
     * @return \Illuminate\Http\Response
     */
    public function flagAsValidated(Proverb $proverb) {
        $user = auth()->user();
        if (!ValidatedProverb::where('proverb_id', $proverb->id)->where('user_id', $user->id)->exists()) {
            ValidatedProverb::create(['proverb_id' => $proverb->id, 'user_id' => $user->id]);
            $proverb->increment('validated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proverb  $proverb
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proverb $proverb) {
        //
    }

}
