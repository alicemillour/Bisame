<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Log;
use App\Http\Requests;
use App\Repositories\GameRepository;
use App\Repositories\PostagRepository;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\AnnotationRepository;
class GameController extends Controller
{
    protected $gameRepository;
    protected $postagRepository;
    protected $annotationRepository;
    protected $gameSentenceIndex;
    public function __construct(GameRepository $gameRepository, PostagRepository $postagRepository, AnnotationRepository $annotationRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->postagRepository = $postagRepository;
        $this->annotationRepository = $annotationRepository;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $current_user = Auth::user();
        $game = $this->gameRepository->getWithUserId($current_user->id)->first();
        if (!$game) {
            $game = $this->gameRepository->store(['user_id' => $current_user->id]);
        }
        return Redirect::route('games.show', ['id' => $game->id]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = $this->gameRepository->getById($id);
        $sentences = $game->sentences;
        $postags = $this->postagRepository->all();
        return view('games.show', compact('sentences', 'postags', 'game'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $current_user = Auth::user();
        $game = $this->gameRepository->getById($id);
        $new_index = $game->sentence_index + 1;
        if ($new_index >= $game->sentences->count()) {
            return;
        } else {
            if ($request->input('annotations')) {
                foreach ($request->input('annotations') as $annotation) {
                    $postag_id = $annotation['postag_id'];
                    $word_id = $annotation['word_id'];
                    if ($postag_id && $word_id) {
                        $annotation = $this->annotationRepository->store(['user_id' => $current_user->id,
                            'word_id' => $word_id, 'postag_id' => $postag_id]);
                    }
                }
            }
            $game->sentence_index = $new_index;
            $game->save();
            $sentence = $game->sentences[$new_index];
            return view('games.sentence', compact('sentence'));
        }
    }
}