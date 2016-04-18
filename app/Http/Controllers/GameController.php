<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Log;
use App\Http\Requests;
use App\Repositories\GameRepository;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\AnnotationRepository;
use App\Repositories\PostagRepository;
use App\Repositories\SentenceRepository;

class GameController extends Controller
{
  protected $gameRepository;  
  protected $sentenceRepository;
  protected $annotationRepository;
  protected $gameSentenceIndex;

  protected function get_game_repository()
  {
    return $this->gameRepository;
  }

  public function __construct(GameRepository $gameRepository, AnnotationRepository $annotationRepository, PostagRepository $postagRepository, SentenceRepository $sentenceRepository)
  {
    $this->gameRepository = $gameRepository;
    $this->annotationRepository = $annotationRepository;
    $this->postagRepository = $postagRepository;
    $this->sentenceRepository = $sentenceRepository;
    $this->middleware('auth');
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
    $game = $this->get_or_create_game();
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
    $repository = $this->get_game_repository();
    $game = $repository->getById($id);
    $this->authorize($game);
    $sentences = $game->sentences;
    return view('games.show', compact('sentences', 'game'));
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
    $repository = $this->get_game_repository();
    $game = $repository->getById($id);
    $this->authorize($game);
    $current_sentence = $game->sentences[$game->sentence_index];
    $new_index = $game->sentence_index + 1;
    if ($current_sentence->is_training()) {
      $this->manage_annotations_of_reference($request->input('annotations'), $current_sentence);
    } else {
      $this->create_annotations($request->input('annotations'));
    }
    $words_annotables=$this->sentenceRepository->getWordNotPunctCount($current_sentence['id']);
    
    $everything_is_annotated = (count($request->input('annotations')) == $words_annotables->word_not_punct_count);
    if ($new_index >= $game->sentences->count()) {
      return $this->finish_game($game);
    } else {
      return $this->go_to_next_sentence($game, $new_index, $everything_is_annotated);
    }
  }

  private function create_annotations($annotations) 
  {
    if ($annotations) {
      $current_user = Auth::user();
      foreach ($annotations as $annotation) {
        $postag_id = $annotation['postag_id'];
        $word_id = $annotation['word_id'];
        if ($postag_id && $word_id) {
          $annotation = $this->annotationRepository->store(['user_id' => $current_user->id,
            'word_id' => $word_id, 'postag_id' => $postag_id]);
        }
      }
    }
  }

  protected function get_or_create_game() {
    $current_user = Auth::user();
    $repository = $this->get_game_repository();
    $game = $repository->getWithUserId($current_user->id)->first();
    if (!$game) {
      $game = $repository->store(['user_id' => $current_user->id, 'sentence_index' => 0]);
    }
    return $game;
  }

  private function go_to_next_sentence($game, $new_index, $everything_is_annotated) {
    $game->sentence_index = $new_index;
    $game->save();
    $sentence = $game->sentences[$new_index];
    return view('games.sentence', compact('sentence','everything_is_annotated'));
  }

  private function finish_game($game) {
    $game->is_finished = true;
    $game->save();
    return;
  }

  private function manage_annotations_of_reference($annotations, $current_sentence) 
  {
    if ($annotations) {
     $status_annotations = $this->check_annotations($annotations, $current_sentence);
     if (!$status_annotations['everything_is_correct']) {
        $current_user = Auth::user();
        $current_user->score =- 1;
        $current_user->save();
      }
    }
  }

  protected function check_annotations($annotations, $sentence) 
  {
    $answers = [];
    $words=$this->sentenceRepository->getWordNotPunctCount($sentence['id']);
    $everything_is_correct = (count($annotations) == $words->word_not_punct_count);
    foreach ($annotations as $annotation) {
      $word_id = $annotation['word_id'];
      $postag_reference = $this->postagRepository
      ->getReferenceForWordId($word_id);
      $postag = $this->postagRepository->getById($annotation['postag_id']);
      $everything_is_correct = $everything_is_correct && 
      ($postag_reference->id == $annotation['postag_id']);
      $answers[] = ['word_id'=> $word_id, 
      'is_correct'=> ($postag_reference->id == $annotation['postag_id']),
      'postag_description' => $postag->description];
    }
    return ["everything_is_correct" => $everything_is_correct,
    "answers" => $answers];
  }

}