<?php 

namespace App\Http\Controllers;

use App\Repositories\TrainingRepository;
use App\Repositories\AnnotationRepository;
use App\Repositories\PostagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;

class TrainingController extends GameController {

  protected $trainingRepository;

  public function __construct(TrainingRepository $trainingRepository, AnnotationRepository $annotationRepository, PostagRepository $postagRepository)
  {
      $this->annotationRepository = $annotationRepository;
      $this->trainingRepository = $trainingRepository;
      $this->postagRepository = $postagRepository;
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
      return Redirect::route('training.show', ['id' => $game->id]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    
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
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    
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
    if ($request->input('annotations')) {
        $sentence = $game->sentences[$game->sentence_index];
        $answers_hash = $this->check_annotations($request->input('annotations'), $sentence);
        if ($answers_hash["everything_is_correct"]) {
          return $this->get_next_sentence_or_finish($game);
        } else {
          return $answers_hash['answers'];
        }
    } else {
      return [];
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    
  }
  
  protected function get_game_repository()
  {
      return $this->trainingRepository;
  }

  private function check_annotations($annotations, $sentence) 
  {
    $current_user = Auth::user();
    $answers = [];
    $everything_is_correct = (count($annotations) == count($sentence->words));
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

  private function get_next_sentence_or_finish($game)
  {
    $new_index = $game->sentence_index + 1;
    if ($new_index >= $game->sentences->count()) {
      $game->is_finished = true;
      $game->save();
      return;
   } else {
      $game->sentence_index = $new_index;
      $game->save();
      $sentence = $game->sentences[$new_index];
      return view('games.sentence', compact('sentence'));
    }
  }
}

?>