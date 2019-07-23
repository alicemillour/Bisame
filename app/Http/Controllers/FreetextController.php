<?php

namespace App\Http\Controllers;

use App\Freetext;
use App\User;
use App\Media;
use App\Anecdote;
use App\Corpus;
use App\Postag;
use App\AnnotatedFreetext;
use App\ValidatedFreetext;
use App;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFreetext;
use App\Http\Requests\StoreAnecdote;
use App\Traits\Badgeable;
use App\Services\WordSeeder;
use App\Services\AnnotationSeeder;
use DB;
use App\Mail\NewFreetext;
use App\Mail\NewAnecdote;
use App\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class FreetextController extends Controller {

    use Badgeable;

    public function __construct() {
        $this->middleware('auth')->only(['create', 'store', 'addAnecdote', 'addMedia', 'favorite', 'alternativeVersions', 'annotations', 'flagAsAnnotated', 'flagAsValidated']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($freetexts = null, $title = null, $subtitle = null) {
        if (!$freetexts)
            $freetexts = Freetext::with('author')->withCount('likes')->orderBy(DB::Raw('annotated+validated'), 'desc')->latest()->paginate(20);
        if (!$title)
            $title = __('freetexts.last-freetexts');

        return view('freetexts.index', [
            'freetexts' => $freetexts,
            'freetexts_to_annotate' => Freetext::with('author')->withCount('likes')->latest()->toAnnotate()->paginate(3),
            'annotated_freetexts' => Freetext::with('author')->withCount('likes')->toValidate()->latest()->paginate(3),
            'validated_freetexts' => Freetext::where('validated', '>', 0)->with('author')->withCount('likes')->latest()->paginate(3),
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
        $freetexts = Freetext::with('author')->withCount('likes')->where('user_id', $user->id)->latest()->paginate(20);

        $title = __('freetexts.freetexts-by', ['name' => $user->name]);

        return $this->index($freetexts, $title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $freetexts = Freetext::with('author')->withCount('likes')->where('title', 'LIKE', '%' . $request->input('search') . '%')->latest()->paginate(20);

        $title = __('freetexts.search-result', ['search' => $request->input('search')]);

        return $this->index($freetexts, $title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function favorite(Request $request) {
        $freetexts = Freetext::with('author')->withCount('likes')->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                            ->from('likes')
                            ->where('likes.user_id', auth()->user()->id)
                            ->where('likes.likeable_type', 'App\Freetext')
                            ->whereRaw('likes.likeable_id = freetexts.id');
                })->paginate(20);

        $title = __('freetexts.favorite', ['search' => $request->input('search')]);

        return $this->index($freetexts, $title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function toAnnotate(Request $request) {
        $freetexts = Freetext::with('author')->withCount('likes')->toAnnotate()->paginate(20);
        $title = __('freetexts.to-annotate');
        $subtitle = __('freetexts.to-annotate-exp');
        return $this->index($freetexts, $title, $subtitle);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function toValidate(Request $request) {
        $freetexts = Freetext::with('author')->withCount('likes')->toValidate()->paginate(20);
        $title = __('freetexts.to-validate');
        $subtitle = __('freetexts.to-validate-exp');
        return $this->index($freetexts, $title, $subtitle);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('freetexts.create')->with('type', "freetexts");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFreetext $request) {
        $freetext = Freetext::create(array_merge($request->all(), array(
                    'user_id' => auth()->user()->id,
                    'corpus_language_id' => 1,
                    'category_id' => $request->input('category_id')
        )));

        if ($request->input('anecdote')) {
            Anecdote::create([
                'user_id' => auth()->user()->id,
                'freetext_id' => $freetext->id,
                'content' => $request->input('anecdote'),
            ]);
        }

        if ($request->input('photos')) {
            foreach ($request->input('photos') as $photo) {
                Media::create([
                    'filename' => $photo,
                    'user_id' => auth()->user()->id,
                    'mediable_id' => $freetext->id,
                    'mediable_type' => "App\Freetext",
                ]);
            }
        }

       $this->checkBadge($request, 'freetext', auth()->user()->freetexts()->count());

        //self::sendMailNewFreetext($freetext);
        
        
        /* Fonctionnalité d'annotation : commenter la ligne ci-dessous pour poursuivre l'exécution i.e. prétraitements et redirection vers l'annotation) */
        // return redirect('/')->withSuccess(__('freetexts.created'));
        /* Fonctionnalité d'annotation */

        /* lancer les prétraitements */
        $script_path = base_path() . '/scripts/'.App::getLocale().'/';
        $corpus_path = storage_path() . '/app/'.App::getLocale().'/corpus/';


        /* tokénisation */
        /* stage 1 : create a raw file with freetext content */
        $filename = preg_replace('/\W+/', '_', $request->input('title'));
        $corpus_name = "freetext_" . $freetext->id . "_" . $filename;
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

        return redirect('freetexts/' . $freetext->id . '?tab=pos')->withSuccess(__('freetexts.created'));
    }

    public function sendMailNewFreetext(Freetext $freetext) {

        $notification = Notification::where('slug', 'all-freetexts')->first();

        foreach ($notification->users as $user) {
            if ($user->email != '') {
                Mail::to($user)->queue(new NewFreetext($freetext));
            }
        }
    }

    public function sendMailNewAnecdote(Freetext $freetext, Anecdote $anecdote) {

        $notification = Notification::where('slug', 'anecdotes')->first();

        $users = $notification->users()->where('user_id', $freetext->user_id)->get();

        foreach ($users as $user) {
            if ($user->email != '') {
                Mail::to($user)->queue(new NewAnecdote($freetext, $anecdote));
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
        // executes after the command finishes1
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

        $freetext = Freetext::findOrFail($request->input('freetext_id'));

        $anecdote = Anecdote::create([
            'user_id' => auth()->user()->id,
            'freetext_id' => $request->input('freetext_id'),
            'content' => $request->input('anecdote'),
        ]);

        $this->checkBadge($request, 'anecdote', auth()->user()->anecdotes()->count());

        self::sendMailNewAnecdote($freetext, $anecdote);

        return redirect('freetexts/' . $request->input('freetext_id'))->withSuccess(__('freetexts.anecdote-created'));
    }

    /**
     * Store a new anecdote.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addMedia(Request $request, Freetext $freetext) {
        if ($request->input('photos')) {
            foreach ($request->input('photos') as $photo) {
                Media::create([
                    'filename' => $photo,
                    'user_id' => auth()->user()->id,
                    'mediable_id' => $freetext->id,
                    'mediable_type' => "App\Freetext",
                ]);
            }
        }

        return redirect('freetexts/' . $request->input('freetext_id'))->withSuccess(__('freetexts.photo-added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Freetext  $freetext
     * @return \Illuminate\Http\Response
     */
    public function show(Freetext $freetext, Request $request) {
        // $freetext = Freetext::findOrFail($id);
        $corpus_freetext = Corpus::where('name', 'like', 'freetext_' . $freetext->id . '_%')->first();
        Log::debug('corpus freetext id' . $freetext->id);
        Log::debug($corpus_freetext);
        $postags = Postag::orderBy('order')->get();
        $tab = 'freetext';

        $message = '';
        $postag = '';
        if ($request->has('pos')) {
            $postag = Postag::find($request->input('pos'));
            $message = "Vous êtes bien entraîné, les " . $postag->name . " n'ont plus de secret pour vous ! Passons aux choses sérieuses :";
        }

        if ($freetext->annotated) {
            $annotated_freetext = AnnotatedFreetext::where('freetext_id', $freetext->id)->first();
            $annotator_to_validate = $annotated_freetext->annotator;
        } else {
            $annotator_to_validate = null;
        }

        if ($request->has('tab')) {
            $tab = $request->input('tab');
            if (!in_array($tab, ['plus', 'pos']))
                $tab = 'freetext';
            if (in_array($tab, ['plus', 'pos']) && !auth()->check())
                return redirect()->route('login')->withErrors("Veuillez vous connecter pour accéder à cette partie du site.");
        }
        return view('freetexts.show', compact('freetext', 'annotator_to_validate', 'corpus_freetext', 'postags', 'tab', 'message', 'postag'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addAltVersion(Request $request) {
        $freetext = Freetext::inRandomOrder()->first();
        $title = __('freetexts.add-variant');
        $subtitle = __('freetexts.add-variant-exp');
        $request->session()->flash('title', $title);
        $request->session()->flash('subtitle', $subtitle);
        return redirect('freetexts/' . $freetext->id . '?tab=plus');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Freetext  $freetext
     * @return \Illuminate\Http\Response
     */
    public function alternativeVersions(Freetext $freetext, Request $request) {
        $request->merge(['tab' => 'plus']);
        return self::show($freetext, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Freetext  $freetext
     * @return \Illuminate\Http\Response
     */
    public function annotations(Freetext $freetext, Request $request) {
        $request->merge(['tab' => 'pos']);
        return self::show($freetext, $request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Freetext  $freetext
     * @return \Illuminate\Http\Response
     */
    public function edit(Freetext $freetext) {
        $this->authorize('update', $freetext);

        return view('freetexts.edit', compact('freetext'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Freetext  $freetext
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFreetext $request, Freetext $freetext) {
        $this->authorize('update', $freetext);

        $freetext->update($request->all());

        Media::where('user_id', auth()->user()->id)->where('mediable_id', $freetext->id)->where('mediable_type', 'App\Freetext')->delete();

        if ($request->input('photos')) {
            foreach ($request->input('photos') as $photo) {
                Media::create([
                    'filename' => $photo,
                    'user_id' => auth()->user()->id,
                    'mediable_id' => $freetext->id,
                    'mediable_type' => "App\Freetext",
                ]);
            }
        }

        return redirect('freetexts')->withSuccess(__('freetexts.updated'));
    }

    /**
     * Flag a freetext as annotated
     *
     * @param  \App\Freetext  $freetext
     * @return \Illuminate\Http\Response
     */
    public function flagAsAnnotated(Freetext $freetext) {
        $user = auth()->user();
        if (!AnnotatedFreetext::where('freetext_id', $freetext->id)->where('user_id', $user->id)->exists()) {
            AnnotatedFreetext::create(['freetext_id' => $freetext->id, 'user_id' => $user->id]);
            $freetext->increment('annotated');
        }
    }

    /**
     * Flag a freetext as verified
     *
     * @param  \App\Freetext  $freetext
     * @return \Illuminate\Http\Response
     */
    public function flagAsValidated(Freetext $freetext) {
        $user = auth()->user();
        if (!ValidatedFreetext::where('freetext_id', $freetext->id)->where('user_id', $user->id)->exists()) {
            ValidatedFreetext::create(['freetext_id' => $freetext->id, 'user_id' => $user->id]);
            $freetext->increment('validated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Freetext  $freetext
     * @return \Illuminate\Http\Response
     */
    public function destroy(Freetext $freetext) {
        //
    }

}
