<?php
namespace App\Http\Controllers;

use App\Models\Word;
use App\Repositories\AnnotationRepository;
use App\Repositories\GameRepository;
use App\Repositories\PostagRepository;
use App\Repositories\SentenceRepository;
use App\Repositories\UserRepository;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class GameController extends Controller
{
  protected $gameRepository;  
  protected $sentenceRepository;
  protected $annotationRepository;
  protected $userRepository;
  protected $gameSentenceIndex;

  protected function get_game_repository()
  {
    return $this->gameRepository;
  }

  public function __construct(GameRepository $gameRepository, AnnotationRepository $annotationRepository, PostagRepository $postagRepository, SentenceRepository $sentenceRepository, UserRepository $userRepository)
  {
    $this->gameRepository = $gameRepository;
    $this->annotationRepository = $annotationRepository;
    $this->postagRepository = $postagRepository;
    $this->sentenceRepository = $sentenceRepository;
    $this->userRepository = $userRepository;
    $this->middleware('auth');
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {

  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  Request  $request
   * @return Response
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
   * @return Response
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
   * @param  Request  $request
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request, $id)
  {
    $user_id=Auth::user()->id;
    $repository = $this->get_game_repository();
    $game = $repository->getById($id);
    $this->authorize($game);
    $current_sentence = $game->sentences[$game->sentence_index];
    $new_index = $game->sentence_index + 1;
        debug($current_sentence->id);
    if ($current_sentence->is_training()) {
        debug("sentence is training");
        //$this->manage_annotations_of_reference($request->input('annotations'), $current_sentence);
        $this->create_annotations($request->input('annotations'), $current_sentence);
        /* update user confidence score */
        $number_total_annotable_words=$this->get_total_annotable_words($user_id)->count;
        $number_correct_annotations=$this->annotationRepository->get_number_correct_annotations($user_id)->count;
        if ($number_total_annotable_words != 0) {
            $new_confidence_score = $number_correct_annotations/$number_total_annotable_words;
        } else {
            $new_confidence_score = 0;
        }
        $this->userRepository->update_confidence_score($user_id, $new_confidence_score);
    } else {
        debug("sentence is regular");
      /* create annotation on non-training sentence */
      $this->create_annotations($request->input('annotations'), $current_sentence);
    }
    $words_annotables=$this->sentenceRepository->getWordNotPunctCount($current_sentence['id']);
    $game_everything_is_annotated = (count($request->input('annotations')) == $words_annotables->word_not_punct_count);
    if ($new_index >= $game->sentences->count()) {
      return $this->finish_game($game);
    } else {
      return $this->go_to_next_sentence($game, $new_index, $game_everything_is_annotated);
    }
  }

  private function create_annotations($annotations, $current_sentence) 
  {
    /* annotations are created on non training sentences and training sentences in regular games */
    if ($annotations) {
      $current_user = Auth::user();
      foreach ($annotations as $annotation) {
        $postag_id = $annotation['postag_id'];
        $word_id = $annotation['word_id'];
        if ($current_sentence->is_training()) {
            /* if current sentence belongs to training corpus, annotation is created with no confidence_score */
            $confidence_score = null;
        } else {
            /* else annotation.confidence_score is set to user.score */
            $confidence_score = $current_user->score;
        }
        debug($confidence_score);
        if ($postag_id && $word_id) {
          $annotation = $this->annotationRepository->store(['user_id' => $current_user->id,
            'word_id' => $word_id, 'postag_id' => $postag_id, 'confidence_score' => $confidence_score]);
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

  private function go_to_next_sentence($game, $new_index, $game_everything_is_annotated) {
    $game->sentence_index = $new_index;
    $game->save();
    $sentence = $game->sentences[$new_index];
    return view('games.sentence', compact('game','sentence', 'game_everything_is_annotated'));
  }

  private function finish_game($game) {
    $game->is_finished = true;
    $game->save();
    return;
  }

  private function manage_annotations_of_reference($annotations, $current_sentence) 
  {
      /*unused*/
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
      debug($postag->full_name);
      $answers[] = ['word_id'=> $word_id, 
      'is_correct'=> ($postag_reference->id == $annotation['postag_id']),
      'postag_name' => $postag->name,
      'postag_full_name' => $postag->full_name,
      'postag_description' => $postag->description];
    }
    return ["everything_is_correct" => $everything_is_correct,
    "answers" => $answers];
  }

    public function get_total_annotable_words($user_id)
        {
            return (Word::select(DB::raw('count(*) as count'))->whereRaw("
                    value NOT REGEXP '^([[:punct:]]|„|“)$' AND
                    sentence_id
                    IN
                   (SELECT sentences.id FROM annotations, words, sentences, corpora                   
                    WHERE words.id=annotations.word_id
                    AND sentences.id=words.sentence_id
                    AND corpora.id=sentences.corpus_id
                    AND corpora.is_training=true
                    AND user_id=?)",Array($user_id))
                   ->first());
    }  
}